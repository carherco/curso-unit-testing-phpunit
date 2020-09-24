<?php

class IbericaConnector
{
  /**
   * @param BookingLine $bl
   * @param             $parametersOfConnector
   * @param             $params
   * @throws TravelException
   */
  public function flightChange(BookingLine &$bl, $parametersOfConnector, $params)
  {

    if (isset($parametersOfConnector['version']) && $parametersOfConnector['version'] === '17.2') {
      $connector172 = new IbericaConnector_17_2($this->token, 'Iberica172');
      return $connector172->flightChange($bl, $parametersOfConnector, $params);
    }

    try {
      global $kernel;
      if (null === $kernel->getContainer()) {
        return;
      }
      $target = IbericaHelper::getTarget($parametersOfConnector);

      $parametersOfConnector['category'] = 'FlightChange';

      ## Split - Delete
      ## Refund
      if (isset($params['delete']) && $params['delete']) {
        ## @important esto solo aplica si es un reembolso de toda la reserva.
        // comprobar si es un reembolso completo.
        $travellers = $bl->getTravellers();
        $complete = true;
        if (is_array($travellers) && !empty($travellers)) {
          foreach ($travellers as $traveller) {
            if ($traveller->isInBooking() && !in_array($traveller->getCode(), $params['passengers'])) {
              $complete = false;
            }
          }
        }
        if (isset($params['confirm']) && $params['confirm']) {
          ## Partial refund should not be used if all of the ticket coupons are open for use,
          # in that case ItinReshop and OrderCancel should be used for total refund.
          if ($bl->hasExtension('Refund_by_change') && $bl->getExtension('Refund_by_change') === false && $complete) {
            $this->cancel($bl, $parametersOfConnector, BookingStatus::REFUNDED);
            return;
          }
          # hacemos la cancelación directamente, si hubiese que separarlo sería desde aquí.
          $orderChangeRQ = IbericaGenerator::generateOrderChangeRQ($bl, $parametersOfConnector, $target, 'delete', $params);
          $orderChangeRS = $kernel->getContainer()
            ->get('acme.iberica.services.methods.order_change')
            ->send($parametersOfConnector, $orderChangeRQ);
          /*$orderChangeRS = file_get_contents('/home/ubuntu/txp/ib/dev/OrderChange_201811075453_rs.xml');
                  $orderChangeRS = new SimpleXML($orderChangeRS);*/
          // Eliminar pasajeros.
          $reader = new IbericaOrderViewReader();
          $reader->readResponse($orderChangeRS, $bl, $parametersOfConnector, 'refund');
        } else {
          $action = ($complete) ? 'Cancel' : 'delete';
          # recuperamos el coste de reembolso para la combinación recibida.
          $itinReshopRQ = IbericaGenerator::generateItinReshopRQ($bl, $parametersOfConnector, $action, $target, $params);
          $itinReshopRS = $kernel->getContainer()
            ->get('acme.iberica.services.methods.itin_reshop')
            ->send($parametersOfConnector, $itinReshopRQ);
          /*$itinReshopRS = file_get_contents('/home/ubuntu/txp/ib/dev/ItinReshop_201811050518_rs.xml');
                  $itinReshopRS = new SimpleXML($itinReshopRS);*/
          // Get new OrderItemId and Amount
          $reader = new IbericaItinReshopReader();
          $reader->readRepriceResponse($itinReshopRS, $bl, $parametersOfConnector, $itinReshopRQ);
        }
      } ## Flight Change Selected. (Reprice and change)
      else if (isset($params['selected']) && !empty($params['selected'])) {
        return $this->setChangeOption($bl, $parametersOfConnector, $params, $kernel->getContainer(), $target);
      } ## Flight Change Get Options.
      else {
        $bl->addExtension('upgrade', $params['upgrade']);
        $bl->addExtension('isChangeFee', true);
        $this->getChangeOptions($bl, $parametersOfConnector, $params, $kernel->getContainer(), $target);
      }
    } catch (\Exception $e) {
      if ($e instanceof TravelException) {
        $item = $e->getError();
        if ($item->getSourceID() === '913') {
          $item->setId('OTHER_OPTIONS_ERROR');
          $ibRs = $item->getDescription();
          $item->setDescription(_('No existen opciones de cambio disponibles.') . "\n" . '(' . $ibRs . ')');
        }
      }
      throw $e;
    }
  }
}

<?php

// Acme\TransportBundle\Service\Backend\CoronavirusService

// ¿Responsabilidad adicional de mandar un email desde esta propia clase?
// ¿Cómo manejo la traducción? _(...)

class CoronavirusService {
  
  /**
   * @param Request $request
   * @return bool
   * @throws InvalidAccessException
   */
  public function processBooking (Request $request) : bool
  {
      # get consolidator id.
      $consolidator = $this->getConsolidator($request);
      $this->consolidatorID = $consolidator;

      try {
          /** @var BookingTicketRefundManager $manager */
          $manager = $this->container->get('acme.commonbundle.booking_ticket_refund.manager');
          $ticket = $manager->find( $request->get('id') );
          if ($ticket === null) {
              throw new RequestParameterException('Ticket doesnt found');
          }
          # check Provider Refund.

          # send Agency Mail.
          $subject = _('Reembolsos COVID19');
          $to = $ticket->getAgencyMail();
          $template = 'Mails/covid19_processed.html.twig';
          $params = [
              'agencyName' => $ticket->getAgencyName(),
              'locator' => $ticket->getLocator(),
          ];
          $this->sendEmail($subject, $to, $template, $params);

          $ticket->setProcessed( new \DateTime() );
          $manager->update( $ticket );
      } catch (\Exception $e) {
          DebugHelper::catchException($e);
          throw $e;
      }

      return true;
  }

}
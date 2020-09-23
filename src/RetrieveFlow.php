<?php

// \Sapiens\Travel\BookingBundle\WorkFlow\RetrieveFlow

// Se define una variable $connector y se usa para llamar al método retrieve del conector corresponndiente

class RetrieveFlow
{
  /**
   * @param BookingRequest $request
   * @param ConnectorParameterRepository $configRepository
   * @return BookingResponse
   */
  public function process(
    BookingRequest $request,
    ConnectorParameterRepository $configRepository
  ) {
    # new response.
    $response = new BookingResponse($request);
    # set booking received as booking response.
    $response->setBooking($request->getBooking());
    # request booking.
    $booking  = $request->getBooking();
    # kernel.
    global $kernel;
    /* @var $translator \Sapiens\Travel\BookingBundle\TranslatorManager */
    $translator = $kernel->getContainer()->get('sapiens_travel_translator_manager');
    # request bookingLines.
    $bls = $booking->getLines();
    # get if is fake.
    $fake = $request->getFake();
    try {
      for ($ibl = 0; $ibl < count($bls); $ibl++) {
        /** @var BookingLine $bl */
        $bl = $bls[$ibl];

        # Si es una acción sobre alguna de las bookingLines y no sobre todas.
        if ($booking->isPartial() && !$bl->isAffected())
          continue;
        $isImport = ($bl->getTravel() == null);

        // Reset warnings and errors
        $bl->setWarnings(NULL);
        $token = $request->getToken();

        $travel = $bl->getTravel();
        $provider = $bl->getProvider();
        $this->currencyConverterService->unConvertTravelPriceFromBookingLine($bl, $request->getClient());
        $this->currencyConverterService->unConvertSupplementsFromBookingLine($bl, $request->getClient(), $request->getAgency());

        $class = ucfirst(strtolower($provider->getShortName()));
        $type = $provider->getType();

        $completeClass = '\\Sapiens\\Travel\\BookingBundle\\Connectors'
          . '\\' . ucfirst(strtolower($type))
          . '\\' . $class
          . '\\' . $class . 'Connector';

        $this->logger->info(self::CONTEXT, self::CATEGORY, $request->getToken(), 'RetrieveFlow.' . $class . ' started');

        $connector = new $completeClass($token, $class);
        if (isset($bl->getTravellers()[0]))
          $bl->getTravellers()[0]->setInBooking(true);
        $connector->regularize($bl);
        if (!$fake) {
          $parameters = $configRepository->getParametersByConnectorAsArray(
            $provider->getId(),
            $request->getClient(),
            $request->getAgency(),
            $request->getTarget()
          );
          $parametersClient = $configRepository->getParametersByConnectorAsArray(
            $provider->getId(),
            $request->getClient(),
            'default',
            $request->getTarget()
          );

          $this->checkConsolidatorIataRp($bl, $parameters, $parametersClient);

          # bug user data.
          if ($request->getAuthor() != null && $request->getAuthor()->getConsolidator() != null) {
            if ($bl->getUser() != null)
              $bl->getUser()->setConsolidator($request->getAuthor()->getConsolidator());
          }

          if ($bl->getTravel() != NULL && $bl->getTravel()->getPrice() != NULL) {
            /**
             * @workaround save void fee.
             */
            $voidFee = $bl->getTravel()->getPrice()->getVoidFee();
            $bl->getTravel()->getPrice()->setVoidFee($voidFee);
          }

          $this->getFeeConsolidator($request, $bl);

          $this->applyOfficeChangeIfSusceptible($request->getClient(), $travel, $parameters);

          $connector->retrieve($bl, $parameters);

          $this->checkONRQ2MANL($bl, $parameters);

          if ($bl->needCancel()) {
            // Si el conector ha marcado que hace falta cancelar la reserva, procedemos a solicitar su cancelación.
            $connector->cancel($bl, $parameters);
            $connector->retrieve($bl, $parameters);

            if ($bl->isStatus(BookingStatus::CANCELLED)) {
              $bl->setNeedCancel(FALSE);
            }
          }

          $bl->setIntelligenceStatus();
          $connector->regularize($bl, $parameters);
        }
        $travel = $bl->getTravel();
        $this->checkBookingAndAddWarning($bl);
        $this->logger->info(self::CONTEXT, self::CATEGORY, $request->getToken(), 'RetrieveFlow.' . $class . ' finished');

        //$bl->setIntelligenceStatus();
      }
    } catch (TravelException $exc) {
      $this->logger->error(self::CONTEXT, self::CATEGORY, $request->getToken(), $exc->getTraceAsString());
      $error = $exc->getError();
      $response->addError($error);

      // -------------- TRANSACTIONS LISTENER
      try {
        $this->logger->setListener('Acme\TransportConnectorBundle\Listeners\TransportListener');
        $message = $exc->getMessage(); // default value
        if ($exc->getError() !== null) {
          $message = $exc->getError()->getId();
          if (!empty($exc->getError()->getDescription())) $message .= self::ERROR_SEPARATOR . $exc->getError()->getDescription();
          elseif (!empty($exc->getError()->getShortName())) $message .= self::ERROR_SEPARATOR . $exc->getError()->getShortName();
        }
        $this->logger->listen(200, $bl->getProvider()->getShortName(), self::CONTEXT, $request->getClient(), $request->getAgency(), $request->getToken(), $message);
      } catch (\Throwable $throwable) {
      }
      // -------------- ---------------------
    } catch (\Throwable $t) {
      $this->logger->error(self::CONTEXT, self::CATEGORY, $request->getToken(), $t->getTraceAsString());
      $error = new Item($t->getMessage());
      $response->addError($error);
    } finally {
      for ($ibl = 0; $ibl < count($bls); $ibl++) {
        /* @var BookingLine $bl */
        $bl = $bls[$ibl];
        if (!empty($bl)) {
          if ($bl->getTravel() != NULL) {
            $tb = $bl->getTravel();
            $translator->translateTravel($tb, $request->getClient());
            if ($tb instanceof Transport && ($bl->isStatus(BookingStatus::CONFIRMED) || $bl->isStatus(BookingStatus::RESERVED))) {
              $tb->setNeedDocApis($tb->needDocApis());
              $bl->checkMissingTickets();
              $bl->checkMissingAnciTickets();
              $bl->checkNoPriceSuppplements();
            }
            try {
              if (empty($bl->getPenalties())) {
                try {
                  $repolicyFlow = new RePolicyFlow();
                  $policyResponse = $repolicyFlow->process($request, $configRepository);
                  if ($policyResponse->hasResults() && !is_null($policyResponse->getResult($ibl))) {
                    $bl->setPenalties($policyResponse->getResult($ibl)->getPenalties());
                  }
                } catch (\Throwable $throwable) {
                }
              }
            } catch (\Exception $e) {
            }
          }

          $this->checkUsedTickets($bl);

          // Sólo actualizamos markup si la reserva está pendiente de emisión.
          // @hack: Se condiciona a que la reserva tenga markup ya aplicado, para NO afectar en aquellas
          // reservas que no contemplaron markup porque tengían las reglas cargadas aún.
          $locators4NoProcess = ['OUZUKY', 'RZJVCC']; // Localizadores que no queremos modificar.
          if (
            $bl->isStatus(BookingStatus::RESERVED) && $bl->getTravel()->getPrice()->getMarkup() != null
            && !in_array($bl->getBookingReference()->getLocator(), $locators4NoProcess) && $tb->getExtension('manually-markup') == false
          ) {
            $mytravels = [$bl->getTravel()];
            $this->getService('sapiens_travel_transport_markup_service')->process(null, $mytravels, $request->getClient(), $request->getAgency());
            if (method_exists($connector, 'regularizeRemoteBooking')) {
              $this->createRemarksByPaxForFares($bl, $parameters);
              $connector->regularizeRemoteBooking($bl, $parameters);
            }
          }

          $bl->regularize($request->getVersion());

          $this->currencyConverterService->processTravelFromBookingLine($bl, $request->getClient(), $request->getAgency());
          $this->currencyConverterService->processSupplementsFromBookingLine($bl, $request->getClient(), $request->getAgency());
          $this->currencyConverterService->processPenaltiesFromBookingLine($bl, $request->getClient(), $request->getAgency());
          $this->currencyConverterService->processTransportNotesFromBookingLine($bl, $request->getClient(), $request->getAgency());
          $this->currencyConverterService->processTicketsFromBookingLine($bl, $request->getClient(), $request->getAgency());
        }
      }
    }

    return $response;
  }
}

<?php

// \Sapiens\Frontend\WebServicesBundle\Services\ExternalPayment\ExternalPaymentBase

// Almacena en la BBDD una petición de pago desde un TPV externo. En la tabla wstravel.secure_payments
// Se llama desde los service de los TPV que tenemos implementados, como por ejemplo desde el método 
// \Sapiens\Frontend\WebServicesBundle\Services\ExternalPayment\RedsysService::createPaymentSession


class ExternalPaymentBase
{
  /**
   * @param null $paymentSession
   * @return SecurePayment|null
   */
  protected function registerPaymentRequest($paymentSession = null): ?SecurePayment
  {
    if ($this->paymentSessionRQ === null) {
      return null;
    }

    try {
      $securePayment = $this->container->get('ws.secure_payment.manager')
        ->findOneBy([
          'clientID' => $this->paymentSessionRQ->getClientID(),
          'transactionCode' => $this->paymentSessionRQ->getTransactionCode(),
        ]);

      if ($securePayment instanceof SecurePayment) {
        if ($paymentSession !== null) {
          $securePayment->setSessionID($paymentSession);
          $this->container->get('ws.secure_payment.manager')
            ->update($securePayment, true);
        }
      } else {
        $securePayment = new SecurePayment();
        $securePayment->setTpvID($this->paymentSessionRQ->getTpvID());
        $securePayment->setClientID($this->paymentSessionRQ->getClientID());
        $securePayment->setAgencyID($this->paymentSessionRQ->getAgencyID());
        $securePayment->setUserID($this->paymentSessionRQ->getUserID());
        if (($bookingID = $this->paymentSessionRQ->getBookingID()) !== null) {
          $securePayment->setBookingID($bookingID);
        }
        $securePayment->setAmount($this->paymentSessionRQ->getAmount());
        $securePayment->setCostForUse($this->paymentSessionRQ->getCostForUse());
        if (($exp = $this->paymentSessionRQ->getExpedient()) !== null) {
          $securePayment->setExpedient($exp);
        }
        $securePayment->setAction($this->paymentSessionRQ->getAction());
        if (($transCode = $this->paymentSessionRQ->getTransactionCode()) !== null) {
          $securePayment->setTransactionCode($transCode);
        }
        $securePayment->setEnvironment($this->getTarget());
        $securePayment->setFinishUrl($this->paymentSessionRQ->getConfirmUrl());
        $this->container->get('ws.secure_payment.manager')
          ->insert($securePayment, true);
      }

      return $securePayment;
    } catch (\Exception $e) {
      $this->container->get(self::MONOLOG)
        ->critical($e->getMessage() . "\n" . $e->getTraceAsString());
      return null;
    }
  }
}

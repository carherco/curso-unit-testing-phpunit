<?php 

class Transport {}

class AvailPreferenceService {

  public const TARIFF_FIELD = '';
  public const CLASS_FIELD = '';

  protected function isValid (Transport $transport, array $rule)
  {
    ## check parameters.
      /**
      * check tariff [ttoo | private]
      * check class.
      */

      if ( (!empty($rule[self::TARIFF_FIELD]) && !$transport->checkTariff($rule[self::TARIFF_FIELD]))

          || (!empty($rule[self::CLASS_FIELD]) && !$transport->checkClass($rule[self::CLASS_FIELD]))

      ) {
      }
  }
}
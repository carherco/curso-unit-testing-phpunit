<?php

// \Sapiens\Travel\CoreBundle\Model\Payment\Card

namespace App\Model;

class Card {

  protected $expireMonth = '';
  protected $fullYear = '';

  
  public function getExpireDate($format='mm/yyyy') {
    $value = str_pad($this->expireMonth, 2, '0', STR_PAD_LEFT) . '/' . $this->getFullYear();
    $format = strtolower($format);
    if ($format=='mm/yyyy') $value = str_pad($this->expireMonth, 2, '0', STR_PAD_LEFT).'/'.$this->getFullYear ();
    if ($format=='mm-yyyy') $value = str_pad($this->expireMonth, 2, '0', STR_PAD_LEFT).'-'.$this->getFullYear ();
    if ($format=='mmyyyy') $value = str_pad($this->expireMonth, 2, '0', STR_PAD_LEFT).$this->getFullYear ();
    if ($format=='mm/yy') $value = str_pad($this->expireMonth, 2, '0', STR_PAD_LEFT).'/'.$this->getYear ();
    if ($format=='mm-yy') $value = str_pad($this->expireMonth, 2, '0', STR_PAD_LEFT).'-'.$this->getYear ();
    if ($format=='mmyy') $value = str_pad($this->expireMonth, 2, '0', STR_PAD_LEFT).$this->getYear ();
    if ($format=='yyyy-mm') $value = $this->getFullYear ().'-'.str_pad($this->expireMonth, 2, '0', STR_PAD_LEFT);
    return $value;
  }


  /**
   * Get the value of expireMonth
   */ 
  public function getExpireMonth()
  {
    return $this->expireMonth;
  }

  /**
   * Set the value of expireMonth
   *
   * @return  self
   */ 
  public function setExpireMonth($expireMonth)
  {
    $this->expireMonth = $expireMonth;

    return $this;
  }

  /**
   * Get the value of fullYear
   */ 
  public function getFullYear()
  {
    return $this->fullYear;
  }

  /**
   * Set the value of fullYear
   *
   * @return  self
   */ 
  public function setFullYear($fullYear)
  {
    $this->fullYear = $fullYear;

    return $this;
  }

  /**
   * Get the value of fullYear
   */ 
  public function getYear()
  {
    return $this->fullYear;
  }
}
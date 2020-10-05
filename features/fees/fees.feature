Feature: Fees on bookings
  Testing fees are correctly applicated to bookings

  Scenario: Reservation with baggages
    When I log in with an agency
    And I search 
    And I click Reservar
    And I add baggages
    Then I should see a total price of '125,52 €'
  
  Scenario: Reservation without any extras
    When I log in with an agency
    And I search 
    And I click Reservar
    Then I should see a total price of '95,52 €'

  
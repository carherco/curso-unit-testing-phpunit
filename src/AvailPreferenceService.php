<?php

namespace App;

use App\Model\Transport;
use App\Deps\ContainerInterface as Container;

/**
 * 2 fases.
 * Fase 1:
 * - For each result check if could be highlighted for all fields except price.
 *   * transport->
 * - isPreferenceOptionable = min[20%, 30%, 40%] = 20% | null
 * - if margin === 0 $transport->isHightlight(true) ?????
 * global $maxMargin = 40% => redis.
 *
 *
 * Fase II: Para todos los resultados ya mezclados.
 * - public function setTransports()
 *    - $this->setFirstElement() => set first element price 100€
 *      -- $this->minumunPrice(100)
 *    - findPreferenceFlights()
 *      foreach ($transports as $transport) {
 *          if (!is_null($transport->getPreferenceMargin()) {
 *              if ($this->checkMargin($transport->getPreferenceMargin(), $this->minumunprice) {
 *                 $transport->isHightlight(true)
 *          }=> for all transport check if a preference could by applied.
 *          - if all preferences are overcost out.
 * end();
 *
 * @todo Rellenar el campo IATA en el TravelRequest.
 */
class AvailPreferenceService
{
    const TARIFF_FIELD = 'tariff';
    const CLASS_FIELD = 'class';

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var int
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $providerId;

    /**
     * @var ?string
     */
    protected $iata;

    /**
     * @var \Datetime
     */
    protected $departureDate;

    /**
     * @var string
     */
    protected $origin;

    /**
     * @var string
     */
    protected $destination;

    /**
     * AvailBlackListService constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param int $clientId
     */
    public function setClientId (int $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param string $providerId
     */
    public function setProviderId (string $providerId)
    {
        $this->providerId = $providerId;
    }

    /**
     * @param string|null $iata
     */
    public function setIata (?string $iata)
    {
        $this->iata = $iata;
    }

    /**
     * @return \Datetime
     */
    public function getDepartureDate(): \Datetime
    {
        return $this->departureDate;
    }

    /**
     * @param \Datetime $departureDate
     */
    public function setDepartureDate(\Datetime $departureDate): void
    {
        $this->departureDate = $departureDate;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     */
    public function setOrigin(string $origin): void
    {
        $this->origin = $origin;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @param array $results
     * @return bool
     */
    public function apply (array &$results)
    {
        # get preference rules.
        $rules = $this->getPreferencesRules();
        if (!is_array($rules) || empty($rules)) {
            return true;
        }
        # apply rules to travels.
        $this->applyRules($results, $rules);
        return true;

    }

    /**
     * @return mixed
     */
    protected function getPreferencesRules()
    {
        return $this->container->get('ws.biz.rules.manager')
                    ->findPreferencesRules(
                        $this->clientId,
                        $this->providerId,
                        $this->departureDate,
                        $this->origin,
                        $this->destination,
                        $this->iata);
    }

    /**
     * @param array $results
     * @param array $rules
     */
    private function applyRules (array &$results, array $rules) : void
    {
        foreach ($results as $result) {
            $this->applyRules2Transport($result, $rules);
        }
    }

    /**
     * @param Transport $transport
     * @param array $rules
     */
    private function applyRules2Transport (Transport &$transport, array $rules) : void
    {
        foreach ($rules as $rule) {
            # check if rule is for provider.
            if (empty($rule['origin']) && empty($rule['destination'])
                && empty($rule[self::TARIFF_FIELD]) && empty($rule[self::CLASS_FIELD])
                && empty($rule['preferred_a']) && empty($rule['preferred_b'])
                && empty($rule['preferred_c'])
            ) {
                # all provider is preferred.
                $transport->addHighLightMargin($rule['pmb_margin']);
                break;
            }
            if (!$this->isValid($transport, $rule)) {
                continue;
            }
            # if we are here is time to set margin.
            $transport->addHighLightMargin($rule['pmb_margin']);
        }
    }

    /**
     * @param Transport $transport
     * @param array $rule
     * @return bool
     */
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
            return false;
        }
        /**
         * check airlines.
         */
        if (!empty($rule['preferred_a']) || !empty($rule['preferred_b']) || !empty($rule['preferred_c'])) {
            $airlines = [];
            $keys = ['a', 'b', 'c'];
            foreach ($keys as $key) {
                if (!empty($rule['preferred_'.$key])) {
                    $airlines[] = strtolower($rule['preferred_'.$key]);
                }
            }
            if (!empty($airlines) && !$transport->checkAirlines($airlines)) {
                return false;
            }
        }
        return true;
    }

}
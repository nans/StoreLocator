<?php

namespace Nans\StoreLocator\Api\Data;

interface AddressInterface
{
    const KEY_COUNTRY = 'country';
    const KEY_STATE   = 'state';
    const KEY_CITY    = 'city';
    const KEY_STREET  = 'street';
    const KEY_ZIP     = 'zip';

    /**
     * @return string
     */
    public function getCountry(): string;

    /**
     * @param string $country
     * @return void
     */
    public function setCountry(string $country);

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param string $state
     * @return void
     */
    public function setState(string $state);

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @param string $city
     * @return void
     */
    public function setCity(string $city);

    /**
     * @return string
     */
    public function getStreet(): string;

    /**
     * @param string $street
     * @return void
     */
    public function setStreet(string $street);

    /**
     * @return string
     */
    public function getZip(): string;

    /**
     * @param string $zip
     * @return void
     */
    public function setZip(string $zip);
}
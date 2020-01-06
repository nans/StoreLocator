<?php

namespace Nans\StoreLocator\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface LocationInterface extends AddressInterface, StatusInterface, ChangeDateInterface, ExtensibleDataInterface
{
    const KEY_ID          = 'location_id';
    const KEY_TITLE       = 'title';
    const KEY_STORE_IDS   = 'store_ids';
    const KEY_SORT_ORDER  = 'sort_order';
    const KEY_DESCRIPTION = 'description';
    const KEY_PHONE       = 'phone';
    const KEY_LATITUDE    = 'latitude';
    const KEY_LONGITUDE   = 'longitude';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title);

    /**
     * @return int
     */
    public function getSortOrder(): int;

    /**
     * @param int $sortOrder
     * @return void
     */
    public function setSortOrder(int $sortOrder);

    /**
     * @return string
     */
    public function getStoreIds(): string;

    /**
     * @param string $storeIds
     * @return void
     */
    public function setStoreIds(string $storeIds);

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     * @return void
     */
    public function setDescription(string $description);

    /**
     * @return string
     */
    public function getPhone(): string;

    /**
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone);

    /**
     * @return string
     */
    public function getLatitude(): string;

    /**
     * @param string $latitude
     * @return void
     */
    public function setLatitude(string $latitude);

    /**
     * @return string
     */
    public function getLongitude(): string;

    /**
     * @param string $longitude
     * @return void
     */
    public function setLongitude(string $longitude);

    /**
     * @return LocationExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * @param LocationExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(LocationExtensionInterface $extensionAttributes);
}
<?php

namespace Nans\StoreLocator\Model;

use Nans\StoreLocator\Api\Data\LocationExtensionInterface;
use Nans\StoreLocator\Model\ResourceModel\Location as ResourceModel;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Location extends AbstractExtensibleModel implements LocationInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'store_location';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getCreationTime(): string
    {
        return $this->getData(self::KEY_CREATION_TIME);
    }

    /**
     * @return string
     */
    public function getUpdateTime(): string
    {
        return $this->getData(self::KEY_UPDATE_TIME);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::KEY_STATUS);
    }

    /**
     * @param int $status
     * @return void
     */
    public function setStatus(int $status)
    {
        $this->setData(self::KEY_STATUS, $status);
    }

    /**
     * @return  void
     */
    public function activate()
    {
        $this->setStatus(self::STATUS_ACTIVE);
    }

    /**
     * @return  void
     */
    public function deactivate()
    {
        $this->setStatus(self::STATUS_INACTIVE);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData(self::KEY_TITLE);
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->setData(self::KEY_TITLE, $title);
    }

    /**
     * @return int
     */
    public function getSortOrder(): int
    {
        return $this->getData(self::KEY_SORT_ORDER);
    }

    /**
     * @param int $sortOrder
     * @return void
     */
    public function setSortOrder(int $sortOrder)
    {
        $this->setData(self::KEY_SORT_ORDER, $sortOrder);
    }

    /**
     * @return string
     */
    public function getStoreIds(): string
    {
        return $this->getData(self::KEY_STORE_IDS);
    }

    /**
     * @param string $storeIds
     * @return void
     */
    public function setStoreIds(string $storeIds)
    {
        $this->setData(self::KEY_STORE_IDS, $storeIds);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getStatus() == self::STATUS_ACTIVE;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->getData(self::KEY_COUNTRY);
    }

    /**
     * @param string $country
     * @return void
     */
    public function setCountry(string $country)
    {
        $this->setData(self::KEY_COUNTRY, $country);
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->getData(self::KEY_STATE);
    }

    /**
     * @param string $state
     * @return void
     */
    public function setState(string $state)
    {
        $this->setData(self::KEY_STATE, $state);
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->getData(self::KEY_CITY);
    }

    /**
     * @param string $city
     * @return void
     */
    public function setCity(string $city)
    {
        $this->setData(self::KEY_CITY, $city);
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->getData(self::KEY_STREET);
    }

    /**
     * @param string $street
     * @return void
     */
    public function setStreet(string $street)
    {
        $this->setData(self::KEY_STREET, $street);
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->getData(self::KEY_ZIP);
    }

    /**
     * @param string $zip
     * @return void
     */
    public function setZip(string $zip)
    {
        $this->setData(self::KEY_ZIP, $zip);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getData(self::KEY_DESCRIPTION);
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->setData(self::KEY_DESCRIPTION, $description);
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->getData(self::KEY_PHONE);
    }

    /**
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone)
    {
        $this->setData(self::KEY_PHONE, $phone);
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->getData(self::KEY_LATITUDE);
    }

    /**
     * @param string $latitude
     * @return void
     */
    public function setLatitude(string $latitude)
    {
        $this->setData(self::KEY_LATITUDE, $latitude);
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->getData(self::KEY_LONGITUDE);
    }

    /**
     * @param string $longitude
     * @return void
     */
    public function setLongitude(string $longitude)
    {
        $this->setData(self::KEY_LONGITUDE, $longitude);
    }

    /**
     * @return LocationExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->getExtensionAttributes();
    }

    /**
     * @param LocationExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(LocationExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
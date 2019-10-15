<?php

namespace Nans\StoreLocator\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Nans\StoreLocator\Model\Location;

class LocationTest extends \PHPUnit\Framework\TestCase
{
    /** @var Location */
    private $location;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->location = $objectManager->getObject(Location::class);
    }

    public function testGettersAndSetters()
    {
        $id = 1;
        $street = 'street';
        $city = 'city';
        $country = 'country';
        $zip = 'zip';
        $phone = '34534545';
        $longitude = '11112222333';
        $latitude = '4444555666';
        $state = 'state';
        $description = 'text';
        $status = Location::STATUS_INACTIVE;
        $title = 'title';
        $storeIds = 5;
        $sortOrder = 10;
        $time = time();

        $this->location->setId($id);
        $this->assertEquals($id, $this->location->getId());

        $this->location->setStatus($status);
        $this->assertEquals($status, $this->location->getStatus());

        $this->location->setTitle($title);
        $this->assertEquals($title, $this->location->getTitle());

        $this->location->setStoreIds($storeIds);
        $this->assertEquals($storeIds, $this->location->getStoreIds());

        $this->location->setSortOrder($sortOrder);
        $this->assertEquals($sortOrder, $this->location->getSortOrder());

        $this->location->setData(Location::KEY_UPDATE_TIME, $time);
        $this->assertEquals($time, $this->location->getUpdateTime());

        $this->location->setData(Location::KEY_CREATION_TIME, $time);
        $this->assertEquals($time, $this->location->getCreationTime());

        $this->location->setDescription($description);
        $this->assertEquals($description, $this->location->getDescription());

        $this->location->setState($state);
        $this->assertEquals($state, $this->location->getState());

        $this->location->setStreet($street);
        $this->assertEquals($street, $this->location->getStreet());

        $this->location->setCity($city);
        $this->assertEquals($city, $this->location->getCity());

        $this->location->setCountry($country);
        $this->assertEquals($country, $this->location->getCountry());

        $this->location->setZip($zip);
        $this->assertEquals($zip, $this->location->getZip());

        $this->location->setPhone($phone);
        $this->assertEquals($phone, $this->location->getPhone());

        $this->location->setLongitude($longitude);
        $this->assertEquals($longitude, $this->location->getLongitude());

        $this->location->setLatitude($latitude);
        $this->assertEquals($latitude, $this->location->getLatitude());
    }

    public function testActiveStatus()
    {
        $this->location->setStatus(Location::STATUS_ACTIVE);
        $this->assertTrue($this->location->isActive());
    }

    public function testActivate()
    {
        $this->location->activate();
        $this->assertEquals(Location::STATUS_ACTIVE, $this->location->getStatus());
    }

    public function testDeactivate()
    {
        $this->location->deactivate();
        $this->assertEquals(Location::STATUS_INACTIVE, $this->location->getStatus());
    }
}
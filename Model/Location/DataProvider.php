<?php

namespace Nans\StoreLocator\Model\Location;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Nans\StoreLocator\Model\ResourceModel\Location\Collection;
use Nans\StoreLocator\Model\ResourceModel\Location\CollectionFactory;
use Nans\StoreLocator\Model\Location;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        /** @var LocationInterface|Location $location */
        foreach ($items as $location) {
            $this->loadedData[$location->getId()] = $location->getData();
        }

        return $this->loadedData;
    }
}

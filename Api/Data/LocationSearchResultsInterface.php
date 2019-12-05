<?php

namespace Nans\StoreLocator\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LocationSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return LocationInterface[]
     */
    public function getItems();

    /**
     * @param LocationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

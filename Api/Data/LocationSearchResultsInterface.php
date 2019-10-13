<?php

namespace Nans\StoreLocator\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LocationSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items
     *
     * @return LocationInterface[]
     */
    public function getItems();

    /**
     * Set items
     *
     * @param LocationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

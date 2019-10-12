<?php

namespace Nans\StoreLocator\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Nans\StoreLocator\Api\Data\LocationSearchResultsInterface;

interface LocationRepositoryInterface
{
    /**
     * @param int $locationId
     * @return LocationInterface
     */
    public function getById(int $locationId);

    /**
     * @param LocationInterface $location
     * @return bool
     * @throws \Exception
     */
    public function delete(LocationInterface $location);

    /**
     * @param LocationInterface $location
     * @return LocationInterface $location
     * @throws AlreadyExistsException
     */
    public function save(LocationInterface $location);

    /**
     * @param int $locationId
     * @return bool
     * @throws \Exception
     */
    public function deleteById(int $locationId);

    /**
     * Search Location
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return LocationSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}

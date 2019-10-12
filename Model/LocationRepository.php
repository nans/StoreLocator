<?php

namespace Nans\StoreLocator\Model;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Nans\StoreLocator\Api\Data\LocationSearchResultsInterface;
use Nans\StoreLocator\Api\LocationRepositoryInterface;
use Nans\StoreLocator\Model\ResourceModel\Location as LocationResourceModel;

class LocationRepository implements LocationRepositoryInterface
{
    /**
     * @var LocationResourceModel
     */
    protected $resourceModel;

    /**
     * @var LocationFactory
     */
    protected $locationFactory;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param LocationResourceModel $resourceModel
     * @param LocationFactory $locationFactory
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        LocationResourceModel $resourceModel,
        LocationFactory $locationFactory,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resourceModel = $resourceModel;
        $this->locationFactory = $locationFactory;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param int $locationId
     * @return LocationInterface
     */
    public function getById(int $locationId)
    {
        $model = $this->locationFactory->create();
        $this->resourceModel->load($model, $locationId);

        return $model;
    }

    /**
     * Delete Location
     *
     * @param LocationInterface|AbstractModel $location
     * @return bool
     * @throws \Exception
     */
    public function delete(LocationInterface $location)
    {
        $this->resourceModel->delete($location);

        return true;
    }

    /**
     * Save Location
     *
     * @param LocationInterface|AbstractModel $location
     * @return LocationInterface $location
     * @throws AlreadyExistsException
     */
    public function save(LocationInterface $location)
    {
        $this->resourceModel->save($location);

        return $location;
    }

    /**
     * Delete Location
     *
     * @param int $locationId
     * @return bool
     * @throws \Exception
     */
    public function deleteById(int $locationId)
    {
        $location = $this->getById($locationId);

        return $this->delete($location);
    }

    /**
     * Search Location
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return LocationSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }
}

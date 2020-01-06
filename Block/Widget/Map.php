<?php

namespace Nans\StoreLocator\Block\Widget;

use Magento\Framework\Api\SortOrder;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Ui\Component\Listing\Column\Cms\Options;
use Magento\Framework\Api\Search\SearchCriteriaBuilderFactory;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Nans\StoreLocator\Api\LocationRepositoryInterface;
use Nans\StoreLocator\Helper\Data;

/**
 * @method Map getHeight():string
 * @method Map getWidth():string
 * @method Map getDescription():string
 */
class Map extends Template implements BlockInterface
{
    protected $_template = "widget/map.phtml";

    /**
     * @var LocationRepositoryInterface
     */
    private $locationRepository;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @param Context $context
     * @param LocationRepositoryInterface $locationRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param StoreManagerInterface $storeManager
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param Data $dataHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        LocationRepositoryInterface $locationRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        StoreManagerInterface $storeManager,
        FilterGroupBuilder $filterGroupBuilder,
        Data $dataHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->locationRepository = $locationRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->storeManager = $storeManager;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return LocationInterface[]
     * @throws NoSuchEntityException
     */
    public function getLocations(): array
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();

        $statusFilter = $this->filterBuilder->create()->setConditionType("eq")->setValue(LocationInterface::STATUS_ACTIVE)->setField(LocationInterface::KEY_STATUS);
        $allStoreFilter = $this->filterBuilder->create()->setConditionType("like")->setValue('%' . Options::ALL_STORE_VIEWS . '%')->setField(LocationInterface::KEY_STORE_IDS);
        $currentStoreFilter = $this->filterBuilder->create()->setConditionType("like")->setValue('%' . $this->getStoreId() . '%')->setField(LocationInterface::KEY_STORE_IDS);

        $storesFilters = $this->filterGroupBuilder->addFilter($allStoreFilter)->addFilter($currentStoreFilter)->create();
        $statusGroupFilter = $this->filterGroupBuilder->addFilter($statusFilter)->create();

        $searchCriteriaWithFilters = $searchCriteriaBuilder->create()->setFilterGroups([$storesFilters, $statusGroupFilter]);

        $sortOrder = $this->sortOrderBuilder->setField(LocationInterface::KEY_SORT_ORDER)->setDirection(SortOrder::SORT_ASC)->create();

        $searchCriteriaWithFilters->setSortOrders([$sortOrder]);

        return $this->locationRepository->getList($searchCriteriaWithFilters)->getItems();
    }

    /**
     * @return string
     */
    public function getLocationsJson(): string
    {
        try {
            $locations = $this->getLocations();
        } catch (NoSuchEntityException $e) {
            $locations = [];
        }

        $locationsArray = [];
        foreach ($locations as $location) {
            $locationsArray[] = $location->toArray();
        }

        return \Zend_Json_Encoder::encode($locationsArray);
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getApiUrl(): string
    {
        return $this->dataHelper->getApiUrl() . '?key=' . $this->dataHelper->getApiKey();
    }

    /**
     * @return int
     * @throws NoSuchEntityException
     */
    protected function getStoreId(): int
    {
        return $this->storeManager->getStore()->getId();
    }
}
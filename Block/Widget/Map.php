<?php

namespace Nans\StoreLocator\Block\Widget;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilderFactory;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Nans\StoreLocator\Api\LocationRepositoryInterface;

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
     * @param Template\Context $context
     * @param LocationRepositoryInterface $locationRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        LocationRepositoryInterface $locationRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->locationRepository = $locationRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return LocationInterface[]
     */
    public function getLocations(): array
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $filter = $this->filterBuilder->create()->setConditionType("eq")->setValue(LocationInterface::STATUS_INACTIVE)->setField(LocationInterface::KEY_STATUS);
        $searchCriteriaWithFilters = $searchCriteriaBuilder->addFilter($filter)->create();

        $sortOrder = $this->sortOrderBuilder->setField(LocationInterface::KEY_SORT_ORDER)->setDirection(SortOrder::SORT_ASC)->create();
        $searchCriteriaWithFilters->setSortOrders([$sortOrder]);

        return $this->locationRepository->getList($searchCriteriaWithFilters)->getItems();
    }
}
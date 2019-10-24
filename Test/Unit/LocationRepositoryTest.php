<?php

namespace Nans\StoreLocator\Test\Unit\Model;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Nans\StoreLocator\Api\Data\LocationSearchResultsInterfaceFactory;
use Nans\StoreLocator\Model\Location;
use Nans\StoreLocator\Model\LocationFactory;
use Nans\StoreLocator\Model\LocationRepository;
use Nans\StoreLocator\Model\ResourceModel\Location as LocationResourceModel;
use Nans\StoreLocator\Model\ResourceModel\Location\Collection;
use Nans\StoreLocator\Model\ResourceModel\Location\CollectionFactory;
use Nans\StoreLocator\Api\Data\LocationSearchResultsInterface;

class LocationRepositoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var LocationRepository|MockObject resourceModelMock
     */
    protected $repositoryModel;

    /**
     * @var LocationResourceModel|MockObject resourceModelMock
     */
    protected $resourceModelMock;

    /**
     * @var LocationFactory|MockObject locationFactoryMock
     */
    protected $locationFactoryMock;

    /**
     * @var Location|MockObject locationMock
     */
    protected $locationMock;

    /**
     * @var FilterBuilder|MockObject filterBuilderMock
     */
    protected $filterBuilderMock;

    /**
     * @var SearchCriteriaBuilder|MockObject searchCriteriaBuilder
     */
    protected $searchCriteriaBuilderMock;

    /**
     * @var SearchCriteria|MockObject searchCriteriaMock
     */
    protected $searchCriteriaMock;

    /**
     * @var LocationSearchResultsInterfaceFactory|MockObject searchResultsFactoryMock
     */
    protected $searchResultsFactoryMock;

    /**
     * @var LocationSearchResultsInterface|MockObject searchResults
     */
    protected $searchResults;

    /**
     * @var CollectionFactory|MockObject collectionFactoryMock
     */
    protected $collectionFactoryMock;

    /**
     * @var Collection|MockObject collection
     */
    protected $collectionMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $collectionProcessor;

    /**
     * @var JoinProcessorInterface|MockObject
     */
    private $joinProcessor;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->resourceModelMock = $this->getMockBuilder(LocationResourceModel::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->locationMock = $this->getMockBuilder(Location::class)
            ->setMethods(['save', 'load'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->locationFactoryMock = $this->getMockBuilder(LocationFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->filterBuilderMock = $this->getMockBuilder(FilterBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchCriteriaBuilderMock = $this->getMockBuilder(SearchCriteriaBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchCriteriaMock = $this->getMockBuilder(SearchCriteria::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchResultsFactoryMock = $this->getMockBuilder(LocationSearchResultsInterfaceFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchResults = $this->getMockBuilder(LocationSearchResultsInterface::class)
            ->setMethods(['setSearchCriteria', 'setTotalCount', 'setItems', 'getItems', 'getTotalCount', 'getSearchCriteria'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionMock = $this->getMockBuilder(Collection::class)
            ->setMethods(['getItems', 'getSize'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionFactoryMock = $this->getMockBuilder(CollectionFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionProcessor = $this->createMock(CollectionProcessorInterface::class);

        $this->joinProcessor = $this->getMockBuilder(JoinProcessorInterface::class)
            ->setMethods(['process', 'extractExtensionAttributes'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryModel = $this->getMockBuilder(LocationRepository::class)
            ->setConstructorArgs([
                'resourceModel'         => $this->resourceModelMock,
                'locationFactory'       => $this->locationFactoryMock,
                'filterBuilder'         => $this->filterBuilderMock,
                'searchCriteriaBuilder' => $this->searchCriteriaBuilderMock,
                'searchResultsFactory'  => $this->searchResultsFactoryMock,
                'collectionFactory'     => $this->collectionFactoryMock,
                'joinProcessor'         => $this->joinProcessor,
                'collectionProcessor'   => $this->collectionProcessor,
            ])
            ->setMethods(null)
            ->getMock();
    }

    public function testRepositoryGetList()
    {
        //create $searchResult -> $this->searchResults
        $this->searchResultsFactoryMock->expects($this->once())->method('create')->willReturn($this->searchResults);

        //create collection
        $collectionSize = 7;
        $this->collectionMock->expects($this->once())->method('getItems')->willReturn([$this->locationMock]);
        $this->collectionMock->expects($this->once())->method('getSize')->willReturn($collectionSize);
        $this->collectionFactoryMock->expects($this->once())->method('create')->willReturn($this->collectionMock);

        //joinProcessor
        $this->joinProcessor->expects($this->once())->method('process')->with($this->collectionMock, LocationInterface::class);

        //collectionProcessor
        $this->collectionProcessor->expects($this->once())->method('process')->with($this->searchCriteriaMock, $this->collectionMock);

        //setSearchCriteria
        $this->searchResults->expects($this->once())->method('setSearchCriteria')->with($this->searchCriteriaMock);

        //setTotalCount
        $this->searchResults->expects($this->once())->method('setTotalCount')->with($collectionSize);

        //setItems
        $this->searchResults->expects($this->once())->method('setItems')->with([$this->locationMock]);
        $this->searchResults->expects($this->once())->method('getItems')->willReturn([$this->locationMock]);

        $list = $this->repositoryModel->getList($this->searchCriteriaMock);

        $this->assertSame($this->searchResults, $list);

        $this->assertSame($this->locationMock, $list->getItems()[0]);
    }

    public function testRepositoryGetById()
    {
        $locationId = 10;

        $this->locationFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->locationMock);
        $this->resourceModelMock->expects($this->once())
            ->method('load')
            ->with($this->locationMock, $locationId)
            ->willReturnSelf();

        $this->assertSame($this->locationMock, $this->repositoryModel->getById($locationId));
    }

    /**
     * @throws \Exception
     */
    public function testRepositoryDelete()
    {
        $this->resourceModelMock->expects($this->once())
            ->method('delete')
            ->with($this->locationMock)
            ->willReturn(true);

        $this->assertTrue($this->repositoryModel->delete($this->locationMock));
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function testRepositorySave()
    {
        $this->resourceModelMock->expects($this->once())
            ->method('save')
            ->with($this->locationMock)
            ->willReturnSelf();

        $this->assertSame($this->locationMock, $this->repositoryModel->save($this->locationMock));
    }
}
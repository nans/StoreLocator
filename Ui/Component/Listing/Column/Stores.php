<?php

namespace Nans\StoreLocator\Ui\Component\Listing\Column;

use Magento\Cms\Ui\Component\Listing\Column\Cms\Options;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\System\Store as SystemStore;
use Nans\StoreLocator\Api\Data\LocationInterface;

class Stores extends Column
{
    /**
     * @var SystemStore
     */
    private $store;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SystemStore $store,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->store = $store;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $storeCollection = $this->store->getStoreCollection();
        try{
            if (isset($dataSource['data']['items'])) {
                foreach ($dataSource['data']['items'] as &$item) {
                    $storeIds = $pieces = explode(",", $item[LocationInterface::KEY_STORE_IDS]);
                    $storeNames = '';
                    /** @var \Magento\Store\Model\Store $store */
                    foreach ($storeIds as $storeId){
                        if($storeId == Options::ALL_STORE_VIEWS){
                            $storeNames .= __('All Store Views').'; ';
                            continue;
                        }
                        $store = $storeCollection[$storeId];
                        $storeNames .= $store->getName().'; ';
                    }
                    $item[$this->getName()] = $storeNames;
                }
            }
            $asd=1;
        }catch (\Throwable $throwable){
            $asd =1;
        }


        return $dataSource;
    }
}
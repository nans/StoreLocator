<?php

namespace Nans\StoreLocator\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Nans\StoreLocator\Helper\Constants;
use Nans\StoreLocator\Model\Location as Model;

class Location extends AbstractDb
{
    const MAIN_TABLE = Constants::DB_PREFIX . 'location';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, Model::KEY_ID);
    }
}
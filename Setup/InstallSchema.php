<?php

namespace Nans\StoreLocator\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Nans\StoreLocator\Helper\Constants;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $this->createLocationTable($setup);
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    public function createLocationTable(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable(Constants::DB_PREFIX . 'location');

        if ($setup->tableExists($tableName)) {
            return;
        }

        $table = $setup->getConnection()->newTable($tableName);

        $this->addPrimaryIdColumn($table, 'location_id');
        $this->addTitleColumn($table);
        $this->addStatusColumn($table);
        $this->addStoreIdsColumn($table);
        $this->addSortOrderColumn($table);
        $table->addColumn(
            'description',
            Table::TYPE_TEXT,
            2000,
            ['nullable' => true],
            'Description'
        );//description
        $table->addColumn(
            'country',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Country'
        );//country
        $table->addColumn(
            'state',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'State'
        );//state
        $table->addColumn(
            'city',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'City'
        );//city
        $table->addColumn(
            'street',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Street'
        );//street
        $table->addColumn(
            'zip',
            Table::TYPE_TEXT,
            100,
            ['nullable' => true],
            'Zip'
        );//zip
        $table->addColumn(
            'phone',
            Table::TYPE_TEXT,
            50,
            ['nullable' => true],
            'Phone'
        );//phone
        $table->addColumn(
            'latitude',
            Table::TYPE_TEXT,
            50,
            ['nullable' => true],
            'Latitude'
        );//latitude
        $table->addColumn(
            'longitude',
            Table::TYPE_TEXT,
            50,
            ['nullable' => true],
            'Longitude'
        );//longitude
        $this->addTimeColumns($table);
        $this->addIndexes($table, $setup);
        $table->setComment('Store Location');
        $setup->getConnection()->createTable($table);
    }

    /**
     * @param Table $table
     * @param int $length
     * @throws \Zend_Db_Exception
     */
    private function addTitleColumn(Table &$table, $length = 255)
    {
        $table->addColumn('title', Table::TYPE_TEXT, $length, ['nullable' => false], 'Title');
    }

    /**
     * @param Table $table
     * @throws \Zend_Db_Exception
     */
    private function addStatusColumn(Table &$table)
    {
        $table->addColumn(
            'status',
            Table::TYPE_SMALLINT,
            1,
            [
                'nullable' => false,
                'unsigned' => true,
                'default'  => 0,
            ],
            'Status'
        );
    }

    /**
     * @param Table $table
     * @param string $title
     * @throws \Zend_Db_Exception
     */
    private function addPrimaryIdColumn(Table &$table, string $title)
    {
        $table->addColumn(
            $title, Table::TYPE_INTEGER, null,
            [
                'identity' => true,
                'nullable' => false,
                'primary'  => true,
                'unsigned' => true,
            ], 'ID'
        );
    }

    /**
     * @param Table $table
     * @param int $length
     * @throws \Zend_Db_Exception
     */
    private function addStoreIdsColumn(Table &$table, int $length = 255)
    {
        $table->addColumn(
            'store_ids', Table::TYPE_TEXT, $length,
            ['nullable' => false, 'default' => '0'], 'Store Ids'
        );
    }

    /**
     * @param Table $table
     * @throws \Zend_Db_Exception
     */
    private function addSortOrderColumn(Table &$table)
    {
        $table->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'unsigned' => true,
            ],
            'Sort Order'
        );
    }

    /**
     * @param Table $table
     * @throws \Zend_Db_Exception
     */
    private function addTimeColumns(Table &$table)
    {
        $table->addColumn(
            'creation_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )
            ->addColumn(
                'update_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false,
                 'default'  => Table::TIMESTAMP_INIT_UPDATE],
                'Modification Time'
            );
    }

    /**
     * @param Table $table
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    private function addIndexes(Table &$table, SchemaSetupInterface $setup)
    {
        $this->addIndex($table, $setup, ['sort_order']);
        $this->addIndex($table, $setup, ['status']);
        $this->addIndex($table, $setup, ['store_ids']);
    }

    /**
     * @param Table $table
     * @param SchemaSetupInterface $setup
     * @param array $fields
     * @throws \Zend_Db_Exception
     */
    private function addIndex(Table &$table, SchemaSetupInterface $setup, array $fields)
    {
        $table->addIndex($setup->getIdxName($table->getName(), $fields), $fields);
    }
}
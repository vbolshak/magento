<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 24.04.16
 * Time: 15:47
 */


$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('bvy_paymentcredit/paymenthistory'))
    ->addColumn('paymenthistory_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'auto_increment' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Id')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'order_id')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'customer_id')
    ->addColumn('total', Varien_Db_Ddl_Table::TYPE_FLOAT, null, array(
        'nullable'  => false,
    ), 'total')
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'total');
$installer->getConnection()->createTable($table);


$installer->endSetup();

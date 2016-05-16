<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 24.04.16
 * Time: 15:47
 */


$installer = $this;
$installer->startSetup();
$installer->run("

ALTER TABLE `{$installer->getTable('sales/quote_payment')}` ADD `comment` VARCHAR( 255 ) NOT NULL ;


ALTER TABLE `{$installer->getTable('sales/order_payment')}` ADD `comment` VARCHAR( 255 ) NOT NULL ;


");
$installer->endSetup();

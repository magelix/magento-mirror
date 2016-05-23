<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 22.05.16
 * Time: 01:17
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

//todo quick and dirty! Change it in  ->newTable style
//todo add table names in config.xml

$installer->run('DROP TABLE IF EXISTS `unic_productimport_entity`;
  CREATE TABLE `unic_productimport_entity` (
  `sku` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT \'simple\',
  `parent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
');

$installer->run('DROP TABLE IF EXISTS `unic_productimport_attribute`;
  CREATE TABLE `unic_productimport_attribute` (
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text,
  `websites` varchar(255) NOT NULL,
  `languages` varchar(255) NOT NULL,
  `is_new` int(11) NOT NULL DEFAULT \'1\',
  PRIMARY KEY (`sku`,`name`,`languages`,`websites`),
  KEY `FK_ENTITY_SKU` (`sku`),
  CONSTRAINT `FK_ENTITY_SKU` FOREIGN KEY (`sku`) REFERENCES `unic_productimport_entity` (`sku`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
');

$installer->endSetup();
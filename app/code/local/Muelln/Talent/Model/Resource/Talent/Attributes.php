<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 22.05.16
 * Time: 15:08
 */

class Muelln_Talent_Model_Resource_Talent_Attributes extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $_isPkAutoIncrement = false;

    function _construct()
    {
        $this->_init('muelln_talent/talent_attribute', 'sku,name,website,languages');
    }
}
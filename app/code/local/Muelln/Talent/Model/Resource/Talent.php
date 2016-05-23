<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 22.05.16
 * Time: 12:57
 */
class Muelln_Talent_Model_Resource_Talent extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $_isPkAutoIncrement = false;

    public function _construct()
    {
        $this->_init('muelln_talent/talent', 'sku');
    }
}
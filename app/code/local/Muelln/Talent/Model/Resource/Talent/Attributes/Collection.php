<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 22.05.16
 * Time: 15:06
 */

class Muelln_Talent_Model_Resource_Talent_Attributes_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    function __construct($resource)
    {
        parent::__construct($resource);
        $this->_init('muelln_talent/talent_attributes');
    }
}
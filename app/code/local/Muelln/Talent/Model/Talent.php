<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 22.05.16
 * Time: 12:48
 */

class Muelln_Talent_Model_Talent extends Mage_Core_Model_Abstract
{
    function _construct()
    {
        parent::_construct();
        $this->_init('muelln_talent/talent');
    }
}
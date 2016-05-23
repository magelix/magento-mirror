<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 22.05.16
 * Time: 01:17
 */ 
class Muelln_Talent_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * @param $item_array
     * @param $lang_lc
     * @return array
     * get the arraykeys for concated description
     */
    public function getdescriptionKeys($item_array, $lang_lc)
    {
        $keys = array();
        foreach(array_keys($item_array) as $key)
        {
            if(preg_match('/^beschreibung_punkt.*'.$lang_lc.'$/', $key))
            {
                $keys[] = $key;
            }
        }
        return $keys;
    }

}
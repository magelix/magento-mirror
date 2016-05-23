<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 22.05.16
 * Time: 15:29
 */

class Muelln_Talent_Model_Csv extends Varien_File_Csv
{
    protected $_lineLength= 0;
    protected $_delimiter = ';';
    protected $_enclosure = '"';
    protected $_filename = 'test.csv';
    protected $_data = array();
    protected $_columnNames = null;

    public function load($filename = null){
        if($filename){
            $this->_data = $this->getData($filename);
        }else{
            $this->_data = $this->getData($this->_filename);
        }
        $this->getColumnNames();
        foreach($this->_data as $key => $value){
            $this->_data[$key] = array_combine($this->_columnNames, array_values($value));
        }
    }

    public function getColumnNames()
    {
        if(!$this->_columnNames){
            $this->_columnNames = array_shift($this->_data);
        }
        return $this->_columnNames;
    }

    public function getDataArray()
    {
        return $this->_data;
    }
}
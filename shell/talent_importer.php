<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 23.05.16
 * Time: 01:22
 */

require_once 'abstract.php';

class Muelln_Shell_Importer extends Mage_Shell_Abstract
{

    public function run()
    {
        if($this->getArg('importfile') !== false || $this->getArg('colorfile') !== false) {
            try {
                $test = Mage::getModel('muelln_talent/csv');
                $test->load($this->getArg('importfile'));
                $mapper = Mage::getModel('muelln_talent/mapper');
                $mapper->initColorMap($this->getArg('colorfile'));

                $mapper->clearTables();

                $mapper->doMapping($test->getDataArray());
                echo 'done.';
            } catch (Exception $e){
                echo 'Import failed: '. $e->getMessage(). "\n";
                echo $this->usageHelp();
            }
        }else{
            echo $this->usageHelp();
        }

    }

    // Usage instructions
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f talent_importer.php -- [options]

  --importfile <argvalue>       CSV Import File
  --colorfile <argvalue>        Color Import File

  help                   This help

USAGE;
    }
}

// Instantiate
$shell = new Muelln_Shell_Importer();

// Initiate script
$shell->run();

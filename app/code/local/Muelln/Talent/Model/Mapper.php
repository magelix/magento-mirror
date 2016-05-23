<?php
/**
 * Created by PhpStorm.
 * User: muelln
 * Date: 22.05.16
 * Time: 17:10
 */

class Muelln_Talent_Model_Mapper extends Mage_Core_Model_Abstract
{
    protected $languages = array('De', 'En', 'Fr', 'It');
    protected $websites = array( 'de' ,'ch' ,'it', 'fr' ,'be', 'lu', 'at' , 'nl' , 'uk');
    protected $colorarray = array();
    /**
     * @var array
     * Mappingtable for doLanguageAttributes
     */
    protected $lang_attribut_map = array(
        'caldera_name' => 'artikelbezeichnung_',
        'meta_description' => 'meta_',
        'meta_title' => 'title_'
        );
    protected $color_attributes_map = array(
        'caldera_color_name' => 'name_',
    );
    /**
     * @var array
     * Mappingtable for doWebsiteAttributes
     */
    protected $wesite_attributes_map = array(
        'price' => 'preis_'
    );
    /**
     * @var array
     * Mappingtable for doOtherAttributes method
     */
    protected $other_attributes_map = array(
        'categories' => 'kategorien',
        'size' => 'groesse',
        'sizeDef' => 'groessendef',
        'calida_serie' => 'serie',
        'calida_size_table' => 'groessentabelle',
        'calida_color_code' => 'farbcode',
        'calida_color_code_hex' => 'farbcode_hex',
        'calida_filter_color' => 'filter_farbe',
        'calida_filter_type' => 'filter_typ',
        'calida_quality_label' => 'calida_quality_label',
        'calida_quality_text' => 'qualitaet_text',
        'calida_care' => 'pflege',
        'calida_hierarchy' => 'calida_hierarchy',
        'calida_season' => 'calida_saison',
        'calida_eat' => 'eat',
        'calida_flag' => 'flag',
        'calida_filter_serie' => 'standard_neuheit',
    );

    /**
     * @throws Exception
     * remove all table entries
     */
    public function clearTables()
    {
        $collection = Mage::getModel('muelln_talent/talent')->getCollection();
        foreach($collection as $item){
            $item->delete();
        }
    }

    /**
     * @param $list
     * @throws Exception
     * executes the mainentity generation and all attribute genertion
     */
    public function doMapping($list)
    {
        foreach($list as $item )
        {
            $entity = Mage::getModel('muelln_talent/talent');
            $entity->setSku($item['ean']);
            $entity->setParent($item['ArtikelNr']);
            $entity->setType('simple');
            $entity->save();
            $this->doLanguageAttributes($item);
            $this->doWebsiteAttributes($item);
            $this->doOtherAttributes($item);
        }
    }

    /**
     * @param $item
     * @throws Exception
     *Usecase language attribute is set
     */
    protected function doLanguageAttributes($item)
    {
        $helper = Mage::helper('muelln_talent');
        $att = Mage::getSingleton('muelln_talent/talent_attributes');
        $this->getColorMap('colors.map');
        /**
         * standard language attributes
         */
        foreach($this->languages as $language){
            $lang_lc = strtolower($language);
            foreach($this->lang_attribut_map as $target => $source){
                $data = array();
                if(isset($item[$source.$lang_lc]) && $item[$source.$lang_lc] != ''){
                    $data['sku'] = $item['ean'];
                    $data['name'] = $target;
                    $data['value'] = $item[$source.$lang_lc];
                    $data['languages'] = $language;
                    $data['websites'] = '';
                    $att->setData($data);
                    $att->save();
                }
            }

        }
        /**
         * concated description
         */
        foreach ($this->languages as $language) {
            $lang_lc = strtolower($language);
            $description = '';
            foreach ($helper->getdescriptionKeys($item, $lang_lc) as $key) {
                if (isset($item[$key]) && $item[$key] != '') {
                    $description .= $item[$key] . "\n";
                }
            }
            $data['sku'] = $item['ean'];
            $data['name'] = 'description';
            $data['value'] = $description;
            $data['languages'] = $language;
            $data['websites'] = '';
            $att->setData($data);
            $att->save();
        }

        $colorcode = 'f'.$item['farbcode'];
        $tmp = $this->colorarray;
        $colormap = $this->colorarray[$colorcode];
        if(isset($colormap)) {
            foreach ($this->languages as $language) {
                $lang_lc = strtolower($language);
                foreach ($this->color_attributes_map as $target => $source) {
                    $data = array();
                    if (isset($item[$source . $lang_lc]) && $item[$source . $lang_lc] != '') {
                        $data['sku'] = $item['ean'];
                        $data['name'] = $target;
                        $data['value'] = $item[$source . $lang_lc];
                        $data['languages'] = $language;
                        $data['websites'] = '';
                        $att->setData($data);
                        $att->save();
                    }
                }
            }
        }
    }

    /**
     * @param $item
     * @throws Exception
     * Case Website attribute is set
     */
    protected function doWebsiteAttributes($item)
    {
        $att = Mage::getSingleton('muelln_talent/talent_attributes');
        foreach ($this->websites as $website) {
            $website_lc = strtolower($website);
            foreach ($this->wesite_attributes_map as $target => $source) {
                $data['sku'] = $item['ean'];
                $data['name'] = $target;
                $data['value'] = $item[$source.$website_lc];
                $data['languages'] = '';
                $data['websites'] = $website;
                $att->setData($data);
                $att->save();
            }
        }
    }

    /**
     * @param $item
     * @throws Exception
     * Usecase for global attributes
     */
    protected function doOtherAttributes($item)
    {
        $att = Mage::getSingleton('muelln_talent/talent_attributes');
        foreach ($this->other_attributes_map as $target => $source) {
            $data['sku'] = $item['ean'];
            $data['name'] = $target;
            $data['value'] = (isset($item[$source]) && $item[$source] != '')? $item[$source]: ' ';
            $data['languages'] = '';
            $data['websites'] = '';
            $att->setData($data);
            $att->save();
        }
    }



    public function initColorMap($filename)
    {
        $colormap = Mage::getModel('muelln_talent/csv');
        $colormap->load($filename);
        foreach($colormap->getDataArray() as $color){
            $this->colorarray['f'.$color['farbcode']] = $color;
        }
    }
}
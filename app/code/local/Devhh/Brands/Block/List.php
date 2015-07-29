<?php

/**
 * Class Devhh_Brands_Block_Footer
 */
class Devhh_Brands_Block_List extends Mage_Core_Block_Template
{
    public function __construct(){
        $this->addData(array(
            'cache_lifetime' => false,
            'cache_tags'     => array(Mage_Cms_Model_Block::CACHE_TAG),
            'cache_key'      => 'brands-list-2',
        ));
    }

    public function getBrandsList()
    {
        $attribute = Mage::getModel('eav/entity_attribute')
            ->loadByCode('catalog_product', 'manufacturer');

        $valuesCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setAttributeFilter($attribute->getData('attribute_id'))
            ->setStoreFilter(0, false);

        $preparedManufacturers = array();
        foreach ($valuesCollection as $value) {
            $preparedManufacturers[] = $value->getValue();
        }

        return $preparedManufacturers;
    }

}
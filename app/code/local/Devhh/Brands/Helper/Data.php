<?php

/**
 * Class Devhh_Brands_Helper_Data
 */
class Devhh_Brands_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * @param $arg_attribute
     * @param $arg_value
     * @return mixed
     */
    public function getValueIdByCode($arg_attribute, $arg_value)
    {
        $attribute_model = Mage::getSingleton('eav/entity_attribute');
        $attribute_options_model = Mage::getSingleton('eav/entity_attribute_source_table');
        $attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
        $attribute = $attribute_model->load($attribute_code);
        $attribute_table = $attribute_options_model->setAttribute($attribute);
        $options = $attribute_options_model->getAllOptions(true);

        foreach ($options as $option) {
            if (stristr($option['label'], $arg_value)) {
                return $option['value'];
            }
        }

        return $arg_value;
    }

    public function getBrandPic($_product)
    {
        $herstellerpic = $_product->getAttributeText('manufacturer');
        $umlaute = Array("/ä/","/ö/","/ü/","/ß/","/ /");
        $ersetzen = Array("ae","oe","ue","ss", "");
        $herstellerpic = utf8_decode($herstellerpic);
        $herstellerpic = strtolower($herstellerpic);
        $herstellerpic = preg_replace($umlaute, $ersetzen, $herstellerpic);

        return utf8_encode($herstellerpic);
    }

    public function getBrandPicByBrandName($brandName)
    {
        $umlaute = Array("/ä/","/ö/","/ü/","/ß/","/ /");
        $ersetzen = Array("ae","oe","ue","ss", "");
        $herstellerpic = utf8_decode($brandName);
        $herstellerpic = strtolower($herstellerpic);
        $herstellerpic = preg_replace($umlaute, $ersetzen, $herstellerpic);

        return utf8_encode($herstellerpic);
    }

}
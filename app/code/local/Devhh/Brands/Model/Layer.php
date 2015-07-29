<?php

/**
 * Class Devhh_Brands_Model_Layer
 */
class Devhh_Brands_Model_Layer extends Sm_Shopby_Model_Catalog_Layer
{

    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection|mixed
     * @throws Exception
     */
    public function getProductCollection()
    {

        if (isset($this->_productCollections[$this->getCurrentCategory()->getId()])) {
            $collection = $this->_productCollections[$this->getCurrentCategory()->getId()];
        } else {

            /** @var Mage_Catalog_Model_Resource_Product_Collection $collection */
            $collection = Mage::getResourceModel('catalog/product_collection')->addAttributeToSelect('*');
            $brandname = Mage::registry('brandname');
            $helper = Mage::helper('devhh_brands/products');
            $optionId = $helper->getValueIdByCode('manufacturer', $brandname);

            // only extension to collection
            $collection = $helper->setBrandFilter($collection, $optionId);

            $this->prepareProductCollection($collection);
            $this->_productCollections[$this->getCurrentCategory()->getId()] = $collection;
        }

        return $collection;
    }
}
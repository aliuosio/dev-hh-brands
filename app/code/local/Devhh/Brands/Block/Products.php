<?php

class Devhh_Brands_Block_Products extends Mage_Catalog_Block_Product_List
{

    /**
     * @var Devhh_Brands_Helper_Products
     */
    protected $_helper;

    /**
     * @var integer
     */
    protected $_optionId;

    /**
     * @var string
     */
    protected $_brandname;

    /**
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        $this->_helper = Mage::helper('devhh_brands/products');
        $this->_brandname = Mage::registry('brandname');
        $this->_optionId = $this->_helper->getValueIdByCode('manufacturer',$this->_brandname);

        $this->addData(array(
            'cache_lifetime' => false,
            'cache_tags' => array(Mage_Catalog_Model_Product::CACHE_TAG),
            'cache_key' => 'brands-list-' . $this->_optionId,
        ));

        parent::__construct();
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
        $breadcrumbs->addCrumb('home', array('label' => Mage::helper('cms')->__('Home'), 'title' => Mage::helper('cms')->__('Home Page'), 'link' => Mage::getBaseUrl()));
        $breadcrumbs->addCrumb('brandname', array('label' => $this->_brandname , 'title' => $this->_brandname));

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLayer()
    {
        $layer = Mage::registry('current_layer');
        if (!$layer) {
            $layer = Mage::getSingleton('devhh_brands/layer');
        }

        return $layer;
    }

    /**
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $layer = $this->getLayer();
            /* @var $layer Mage_Catalog_Model_Layer */
            if ($this->getShowRootCategory()) {
                $this->setCategoryId(Mage::app()->getStore()->getRootCategoryId());
            }

            // if this is a product view page
            if (Mage::registry('product')) {
                /**
                 * @var $categories Mage_Catalog_Model_Product
                 */
                $categories = Mage::registry('product')->getCategoryCollection()
                    ->setPage(1, 1)
                    ->load();
                // if the product is associated with any category
                if ($categories->count()) {
                    // show products from this category
                    $this->setCategoryId(current($categories->getIterator()));
                }
            }

            $origCategory = null;
            if ($this->getCategoryId()) {
                $category = Mage::getModel('catalog/category')->load($this->getCategoryId());
                if ($category->getId()) {
                    $origCategory = $layer->getCurrentCategory();
                    $layer->setCurrentCategory($category);
                    $this->addModelTags($category);
                }
            }

            // only diference to normal collection
            $this->_productCollection = $this->_helper->setBrandFilter($layer->getProductCollection(), $this->_optionId);

            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

            if ($origCategory) {
                $layer->setCurrentCategory($origCategory);
            }
        }

        return $this->_productCollection;
    }

}

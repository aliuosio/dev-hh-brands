<?php

/**
 * Class Devhh_Brands_Block_Footer
 */
class Devhh_Brands_Block_Brandname extends Mage_Core_Block_Text
{
    protected function _toHtml()
    {
        return '<div class="page-title category-title"><h1>Hersteller: ' . Mage::registry('brandname') . '</h1></div>';
    }
}
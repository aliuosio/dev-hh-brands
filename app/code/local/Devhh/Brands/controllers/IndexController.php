<?php

require_once 'Sm/Shopby/controllers/CategoryController.php';
class Devhh_Brands_IndexController extends Sm_Shopby_CategoryController
{

    public function indexAction()
    {
        $name = $this->getRequest()->getParam('name', null);
        if (is_null($name)) {
            $this->_forward('noRoute');
        }

        $name = urldecode($name);
        Mage::register('brandname', $name);
        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($name);
        $this->renderLayout();
    }

}
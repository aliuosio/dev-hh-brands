<?php

/**
 * Class Devhh_Brands_Helper_Data
 */
class Devhh_Brands_Helper_Products extends Devhh_Brands_Helper_Data
{

    /**
     * @param $collection
     * @param $optionId
     * @return mixed
     * @throws Exception
     */
    public function setBrandFilter($collection, $optionId)
    {
        if (!is_null($optionId)) {
            try {
                $collection->addAttributeToFilter('manufacturer', $optionId);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        return $collection;
    }

}
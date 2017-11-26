<?php

class Interactiv4_GAConversionTrack_Model_System_Config_Source_Product
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];

        foreach ($this->toArray() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $options = [];

        /** @var Mage_Catalog_Model_Resource_Product_Collection $collection */
        $collection = Mage::getResourceSingleton('catalog/product_collection')
            ->addAttributeToSelect(['name', 'sku']);

        /** @var Mage_Catalog_Model_Product $item */
        foreach ($collection as $item) {
            $options[$item->getSku()] = $item->getSku() . ' | ' . $item->getName();
        }

        return $options;
    }
}

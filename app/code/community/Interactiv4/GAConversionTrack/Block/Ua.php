<?php
/**
 * Atwix
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 * @category    Atwix
 * @package     Atwix_UniversalAnalytics
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2012 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Interactiv4_GAConversionTrack_Block_Ua extends Mage_Core_Block_Template
{
    /**
     * Render information about specified orders and their items
     *
     * @link https://developers.google.com/analytics/devguides/collection/analyticsjs/ecommerce
     * @return string
     */
    protected function _getOrdersTrackingCode()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $collection = Mage::getResourceModel($this->jsQuoteEscape('sales/order_collection'))
            ->addFieldToFilter('entity_id', array('in' => $orderIds));
        $result = array();

        /** @var Mage_Sales_Model_Order $order */
        foreach ($collection as $order) {
            $itemsData = [];

            /** @var Mage_Sales_Model_Order_Item $item */
            foreach ($order->getAllVisibleItems() as $item) {
                $itemsData[] = sprintf(
                    "{
                    'id': '%s',
                    'name': '%s',
                    'sku': '%s',
                    'category': '%s',
                    'price': '%s',
                    'quantity': '%s'
                }",
                    $order->getIncrementId(),
                    $this->jsQuoteEscape($item->getName()),
                    $this->jsQuoteEscape($item->getSku()),
                    null,
                    $item->getBasePrice(),
                    intval($item->getQtyOrdered())
                );
            }

            $result[] = sprintf(
                "gtag('event', 'purchase', {
                'transaction_id': '%s',
                'affiliation': '%s',
                'value': '%s',
                'currency': '%s',
                'tax': '%s',
                'shipping': '%s',
                'items': [%s]
            });",
                $order->getIncrementId(),
                $this->jsQuoteEscape($order->getStore()->getFrontendName()),
                $order->getBaseGrandTotal(),
                $order->getOrderCurrencyCode(),
                $order->getBaseTaxAmount(),
                $order->getBaseShippingAmount(),
                implode(',', $itemsData)
            );
        }
        return implode("n", $result);
    }

    public function getAccountParams()
    {
        $params = [];

        if (Mage::getIsDeveloperMode()) {
            $params = ['cookie_domain' => 'none'];
        }

        return Mage::helper('core')->jsonEncode($params);
    }

    /**
     * Prepare block to HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::helper('i4gaconversiontrack')->isAvailable()) {
            return '';
        }

        return parent::_toHtml();
    }
}
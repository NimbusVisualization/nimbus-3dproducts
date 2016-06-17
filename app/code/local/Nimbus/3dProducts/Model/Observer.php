<?php

class Nimbus_3dproducts_Model_Observer
{
	/**
	 * @param Varien_Event_Observer $observer
	 */
	public function convertCustomValues($observer)
	{
		$form = $observer->getEvent()->getForm();
		$customValues = $form->getElement('nimbus_object');
		if ($customValues) {
			$customValues->setRenderer(
					Mage::app()->getLayout()->createBlock('nimbus3d/adminhtml_product_custom')
			);
		}
	}

	/**
	 * @param Varien_Event_Observer $observer $observer
	 */
	public function placeOrder($observer)
	{
		/* @var $order Mage_Sales_Model_Order */
		$order = $observer->getEvent()->getOrder();
		if (!$order) {
			return;
		}
		
		$nimbusProducts = array();
		foreach ($order->getAllItems() as $item) {
			/* @var $item Mage_Sales_Model_Order_Item */
			
			// Product may not have Nimbus attribute loaded as part of the order process. Reload if so.
			$product = $item->getProduct();
			if (!$product->hasData('nimbus_object')) {
				$product = Mage::getModel('catalog/product')->load($product->getId());
			}
			
			$data = $product->getNimbusObject();
			if (!empty($data['product'])) {
				$nimbusProducts[$data['product']] = $item->getQtyOrdered();
			}
		}
		
		Mage::getSingleton('nimbus3d/session')->saveOrderItems($nimbusProducts);
	}
}

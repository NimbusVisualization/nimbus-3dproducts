<?php

class Nimbus_3dProducts_Model_Session
{
	const SESSION_KEY = 'nimbus3d';
	
	/**
	 * @param array $items map Nimbus product IDs to quantity
	 */
	public function saveOrderItems($items)
	{
		// Add to any existing order info (just in case)
		$saved = $this->getOrderItems();
		foreach ($items as $productId=>$quantity) {
			if (array_key_exists($productId, $saved)) {
				$saved[$productId] += $quantity;
			}
			else {
				$saved[$productId] = $quantity;
			}
		}
		
		Mage::getSingleton('customer/session')->setData(self::SESSION_KEY, $saved);
	}
	
	/**
	 * @return array
	 */
	public function getOrderItems($clear = true)
	{
		$items = Mage::getSingleton('customer/session')->getData(self::SESSION_KEY, $clear);
		return is_array($items) ? $items : array();
	}
}
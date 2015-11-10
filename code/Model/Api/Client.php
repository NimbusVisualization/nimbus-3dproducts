<?php

class Nimbus_3dProducts_Model_Api_Client
{
	protected $api_url = 'http://localhost/nimbus-api/public/api/v1/';
	protected $viewer_url = 'http://localhost/nimbus-api/public/viewer/';
	protected $cache = array();
	
	/**
	 * @param Mage_Catalog_Model_Product $product
	 * @return object|false
	 */
	public function getModelInfo($product)
	{
		$data = $product->getNimbusObject();

		if (!empty($data['product']))
			return $this->request('products/' . $data['product']);
		else
			return false;
	}

	/**
	 * @param Mage_Catalog_Model_Product $product
	 * @return string|false
	 */
	public function getViewerUrl($product)
	{
		$data = $product->getNimbusObject();
		if (!empty($data['product']))
			return $this->viewer_url . $data['product'];
		else
			return false;
	}
	
	/**
	 * @param string $api_segments
	 * @return object|false
	 */
	protected function request($api_segments)
	{
		if (isset($this->cache[$api_segments]))
			return $this->cache[$api_segments];
		
		Mage::log("Nimbus API: $api_segments", Zend_Log::DEBUG);
		
		$result = false;
		try {
			$curl = curl_init();
			curl_setopt_array($curl, array(
					CURLOPT_URL => $this->api_url . $api_segments,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CONNECTTIMEOUT => 10,
					CURLOPT_TIMEOUT=>10
				));
			$response = curl_exec($curl);

			if (curl_errno($curl))
				Mage::throwException(Mage::helper('nimbus')->__("CURL Error: %s", curl_error($curl)));

			$this->cache[$api_segments] = $result = $response ?: false;
			
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		return $result;
	}
}
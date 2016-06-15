<?php

class Nimbus_3dProducts_Model_Api_Client
{
    protected $helper;
	protected $cache = array();

    public function __construct()
    {
        $this->helper = Mage::helper('nimbus3d');
    }

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
	 * @return string|false
	 */
	public function getClientId()
	{
		return $this->helper->client_id ?: false;
	}
	
	/**
	 * @return string|false
	 */
	public function getApiUrl()
	{
		if (empty($this->helper->client_id))
			return false;
		else
			return $this->helper->api_base_url . 'api/v1/';
	}

	/**
	 * @param Mage_Catalog_Model_Product $product
	 * @return string|false
	 */
	public function getViewerUrl($product)
	{
		$data = $product->getNimbusObject();
		if (!empty($data['product']) && !empty($this->helper->client_id))
			return $this->helper->api_base_url . 'viewer/' . $data['product'] . '?client_id=' . $this->helper->client_id;
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
					CURLOPT_URL => $this->getApiUrl() . $api_segments,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CONNECTTIMEOUT => 10,
					CURLOPT_TIMEOUT=>10
				));
			$response = curl_exec($curl);

			if (curl_errno($curl))
				Mage::throwException(Mage::helper('nimbus3d')->__("CURL Error: %s", curl_error($curl)));

			$this->cache[$api_segments] = $result = $response ?: false;
			
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		return $result;
	}
}
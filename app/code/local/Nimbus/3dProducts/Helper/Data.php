<?php

class Nimbus_3dproducts_Helper_Data extends Mage_Core_Helper_Data {

	public $client_id;
	public $client_secret;
	public $api_base_url;

    public function __construct()
    {
        $config = Mage::getStoreConfig('nimbus_3dproducts/config');
        
        $this->client_id = $config['client_id'];
		$this->client_secret = $config['client_secret'];

        // set default API URL when empty
        if (empty($config['api_base_url']))
        	$this->api_base_url = 'https://api.nimbusreality.com';
        else
        	$this->api_base_url = $config['api_base_url'];

        // trailing slash expected
        $this->api_base_url = rtrim($this->api_base_url, '/') . '/';
      
    }

	/**
	 * Generate a hash signature incorporating a client's secret.
	 * Based on OAuth 1.0a signature procedure.
	 * 
	 * @param string|array $content
	 * @return string
	 */
	public function signature($content)
	{
		if (is_array($content)) {
			$content = $this->arrayToString($content);
		}
		
		return hash_hmac('sha256', $content, $this->client_secret);
	}
	
	/**
	 * Reduce an array of data to a string that can be hashed, ensuring a
	 * consistent element order.
	 * 
	 * @param array $array
	 * @return string
	 */
	protected function arrayToString($array)
	{
		$result = '';
		$keys = array_map('rawurlencode', array_keys($array));
		sort($keys);
		foreach ($keys as $key) {
			if ($result) {
				$result .= '&';
			}
			
			$val = $array[$key];
			$result .= "$key=";
			$result .= is_array($val) ? '%5B' . self::arrayToString($val) . '%5D' : rawurlencode($val);
		}
		
		return $result;
	}
}

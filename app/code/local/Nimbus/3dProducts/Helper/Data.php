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

}

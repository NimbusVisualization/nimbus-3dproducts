<?php

class Nimbus_3dproducts_Helper_Data extends Mage_Core_Helper_Data {

	public $access_token;
	public $api_base_url;

    public function __construct()
    {
        $config = Mage::getStoreConfig('nimbus_3dproducts/config');
        
        $this->access_token = $config['access_token'];

        // set default API URL when empty
        if (empty($config['api_base_url']))
        	$this->api_base_url = 'http://api.nimbusvisualization.com';
        else
        	$this->api_base_url = $config['api_base_url'];

        // trailing slash expected
        $this->api_base_url = rtrim($this->api_base_url, '/') . '/';
      
    }

}

<?php

$installer = $this;
$installer->startSetup();

// Use nimbus3d as the module short name
$installer->updateAttribute('catalog_product', 'nimbus_object', 'backend_model', 'nimbus3d/handler');

$installer->endSetup();

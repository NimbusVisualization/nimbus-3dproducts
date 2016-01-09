<?php

$installer = $this;
$installer->startSetup();

$group = 'Nimbus 3D Products';

$installer->addAttribute('catalog_product', 'nimbus_object', array(
        'type'      => 'text',
        'input'     => 'text',
        'label'     => 'Nimbus Object',
        'backend'   => 'nimbus/handler',
        'global'    => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'   => 1,
        'required'  => 0,
        'position'  => 10,
        'group'     => $group
    ));


$installer->endSetup();

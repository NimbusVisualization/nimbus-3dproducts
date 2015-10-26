<?php

$installer = $this;
$installer->startSetup();

$group = 'Nimbus 3D Products';
$installer->removeAttribute('catalog_product', 'nimbus_test');
$installer->addAttribute('catalog_product', 'nimbus_object_id', array(
        'type'      => 'text',
        'input'     => 'text',
        'label'     => 'Nimbus Object ID',
        'global'    => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'   => 1,
        'required'  => 0,
        'position'  => 10,
        'group'     => $group
    ));


$installer->endSetup();

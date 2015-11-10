<?php
class Nimbus_3dproducts_Model_Observer {
    public function convertCustomValues($observer) {
        $form = $observer->getEvent()->getForm();
        $customValues = $form->getElement('nimbus_object');
        if ($customValues) {
            $customValues->setRenderer(
                Mage::app()->getLayout()->createBlock('nimbus_3dproducts/adminhtml_product_custom')
            );
        }
    }
}
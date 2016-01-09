<?php
class Nimbus_3dproducts_Model_Handler extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract{
    public function beforeSave($object) 
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $data = $object->getData($attributeCode);
        if (is_array($data)) {
            $data = array_filter($data);
            $object->setData($attributeCode, serialize($data));
        }
        return parent::beforeSave($object);
    }
    public function afterLoad($object) {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $data = $object->getData($attributeCode);
        if (!is_array($data)) {
            $object->setData($attributeCode, @unserialize($data));
        }
        return parent::afterLoad($object);
    }
}
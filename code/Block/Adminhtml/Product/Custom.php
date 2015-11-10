<?php
class Nimbus_3dProducts_Block_Adminhtml_Product_Custom
    extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface {

   public function _prepareLayout() 
   {
      $head = $this->getLayout()->getBlock('head');

      $head->addCss('nimbus/selectize.css');

      $head->addJs('nimbus/jquery.min.js');
      $head->addJs('nimbus/jquery_noconflict.js');
      
      $head->addJs('nimbus/selectize.min.js');
      $head->addJs('nimbus/form.js');

      return parent::_prepareLayout();
   }

    public function __construct()
    {
        $this->setTemplate('nimbus/product/custom.phtml'); //set a template
    }
    public function render(Varien_Data_Form_Element_Abstract $element) {
        $this->setElement($element);
        return $this->toHtml();
    }
}
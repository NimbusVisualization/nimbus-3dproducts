<?php
/**
 * Nimbus 3D Products controller
 *
 * @category    Nimbus
 * @package     3dProducts
 * @author      Aspen Digital <info@aspendigital.com>
 */
class Nimbus_3dProducts_ValidateController extends Mage_Core_Controller_Front_Action
{

    public $test = 'THIS IS A TEST';

    // public function preDispatch()
    // {
    //     parent::preDispatch();
    // }

    function testAction() {

        echo $this->test;

    }


}
<?php
namespace Tests;
use Models\Product;

class ProductTest extends \PHPUnit_Framework_TestCase{
    private $obj;
    function setUp(){
        $this->obj = $this->getMockForAbstractClass('Models\Product');

    }
    public function testPriceIsEmpty(){
        $this->expectException('Exception');
        //$p = new BasicProduct('', '', '');
        $this->obj->validateVariables('','ako',false);
    }
    public function testPriceIsNull(){
        $this->expectException('Exception');
        $this->obj->validateVariables(null, 'ako', true);
    }
    public function testPriceIsNotNumeric(){
        $this->expectException('Exception');
        $this->obj->validateVariables('abcd', 'ako',false);
    }
    public function testDescriptionEmpty(){
        $this->expectException('Exception');
        $this->obj->validateVariables(12.00, '',false);
    }
    public function testDescriptionNull(){
        $this->expectException('Exception');
        $this->obj->validateVariables(123, null, false);
    }
    public function testIsimportedIsANumber(){
        $this->expectException('Exception');
        $this->obj->validateVariables(123, 'my desc', 1);
    }
    public function testIsimportedIsAString(){
        $this->expectException('Exception');
        $this->obj->validateVariables(123, 'my desc', '1');
    }
    public function testIsimportedIsNull(){
        $this->expectException('Exception');
        $this->obj->validateVariables(123, 'my desc', null);
    }
    public function testRoundSalesTaxWhenNIsNull(){
        $this->expectException('Exception');
        $tax = $this->invokeMethod($this->obj, 'roundSalesTax',array(null));
    }
    public function testRoundSalesTaxWhenNIsEmpty(){
        $this->expectException('Exception');
        $tax = $this->invokeMethod($this->obj, 'roundSalesTax',array(''));
    }
    public function testRoundSalesTaxWhenNIsString(){
        $this->expectException('Exception');
        $tax = $this->invokeMethod($this->obj, 'roundSalesTax',array('abcd'));
    }
    public function testRoundSalesTaxWhenNIsStringWithNumber(){
        $this->expectException('Exception');
        $tax = $this->invokeMethod($this->obj, 'roundSalesTax',array('abcd1234'));
    }
    private function invokeMethod(&$object, $methodName, array $parameters = array()){
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object,$parameters);
    }
}
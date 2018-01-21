<?php
namespace Tests;
use Models\BasicProduct;


class BasicProductTest extends \PHPUnit_Framework_TestCase{
    private $obj;
    public function testComputeNetPrice(){
        $p = new BasicProduct(14.99, 'music CD', false);
        $netPrice = $p->computeNetPrice();
        $this->assertEquals(16.49,$netPrice);
    }
    public function testGetTaxesPaidWhenItemIsNotImported(){
        $p = new BasicProduct(123, 'My Description',false);
        $tax = $this->invokeMethod($p, 'roundSalesTax',array(12.3));
        $this->assertEquals($tax, $p->getTaxesPaid());
    }
    public function testGetTaxesPaidWhenItemIsImported(){
        $p = new BasicProduct(27.99, 'My Description',true);
        $tax = $this->invokeMethod($p, 'roundSalesTax',array(4.1985));
        $this->assertEquals($tax, $p->getTaxesPaid());
    }
    public function testGetDescription(){
        $desc = 'I am desc';
        $p = new BasicProduct(123, $desc);
        $this->assertEquals($desc, $p->getDescription());
    }
    public function testComputeNetPricesFromTestData(){
        //basket 1
        $myCd = new BasicProduct(14.99,'music CD',false);
        //basket 2
        $impPerfume = new BasicProduct(47.50, '1 imported bottle of perfume',true);
        //basket 3
        $impPerfume2 = new BasicProduct(27.99, '1 imported bottle of perfume',true);
        $perfume1 = new BasicProduct(18.99, '1 bottle of perfume',false);
        //outputs
        $this->assertEquals(16.49, $myCd->computeNetPrice());
        $this->assertEquals(54.65, $impPerfume->computeNetPrice());
        $this->assertEquals(32.19, $impPerfume2->computeNetPrice());
        $this->assertEquals(20.89, $perfume1->computeNetPrice());

    }
    private function invokeMethod(&$object, $methodName, array $parameters = array()){
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object,$parameters);
    }

}
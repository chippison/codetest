<?php
namespace Tests;
use Models\SalesTaxExemptProduct;

class SalesTaxExemptProductTest extends \PHPUnit_Framework_TestCase{
    private $obj;

    public function testGetTaxesPaidWhenItemIsNotImported(){
        $p = new SalesTaxExemptProduct(123, 'My Description',false);
        $tax = $this->invokeMethod($p, 'roundSalesTax',array(0));
        $this->assertEquals($tax, $p->getTaxesPaid());
    }
    public function testGetTaxesPaidWhenItemIsImported(){
        $p = new SalesTaxExemptProduct(27.99, 'My Description',true);
        $tax = $this->invokeMethod($p, 'roundSalesTax',array(1.3995));
        $this->assertEquals($tax, $p->getTaxesPaid());
    }
    public function testGetDescription(){
        $desc = 'I am desc';
        $p = new SalesTaxExemptProduct(123, $desc,false);
        $this->assertEquals($desc, $p->getDescription());
    }
    public function testComputeNetPricesFromTestData(){
        //basket 1
        $mybook = new SalesTaxExemptProduct(12.49,'1 book',false);
        $chocBar1 = new SalesTaxExemptProduct(0.85,'1 chocolate bar',false);
        //basket 2
        $impChoc = new SalesTaxExemptProduct(10.00, '1 imported box of chocolates',true);
        //basket 3
        $pills = new SalesTaxExemptProduct(9.75, '1 packet of headache pills',false);
        $impChoc2 = new SalesTaxExemptProduct(11.25, '1 box of imported chocolates',true);
        //outputs
        $this->assertEquals(12.49, $mybook->computeNetPrice());
        $this->assertEquals(0.85, $chocBar1->computeNetPrice());
        $this->assertEquals(10.50, $impChoc->computeNetPrice());
        $this->assertEquals(9.75, $pills->computeNetPrice());
        $this->assertEquals(11.85, $impChoc2->computeNetPrice());

    }
    private function invokeMethod(&$object, $methodName, array $parameters = array()){
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object,$parameters);
    }
}
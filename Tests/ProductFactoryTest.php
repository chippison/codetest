<?php
namespace Tests;
use Models\ProductFactory;

class ProductFactoryTest extends \PHPUnit_Framework_TestCase{
    private $obj;
    function setUp(){
        $this->obj = new ProductFactory();
    }
    public function testCreateProductsWithEmptyArray(){
        $this->assertEquals(0, count($this->obj->createProducts(array())));
    }
    public function testCreateProductsWithNull(){
        $this->expectException('Exception');
        $prod = $this->obj->createProducts(null);
    }
    public function testCreateProductsWithString(){
        $this->expectException('Exception');
        $prod = $this->obj->createProducts('ako');
    }
    public function testCreateProductsWithNumber(){
        $this->expectException('Exception');
        $prod = $this->obj->createProducts(1);
    }
    public function testCreateProductWithArrayWithoutKeyDescription(){
        $this->expectException('Exception');
        $arr = array(
            'quantity'=>1,
            'price'=>12.4,
        );
        $prod = $this->obj->createProducts(array($arr));
    }
    public function testCreateProductWithPriceNotValid(){
        $this->expectException('Exception');
        $arr1 = array(
            array('quantity'=>1,'description'=>'imported box of chocolates','price'=>null),
            array('quantity'=>1,'description'=>'imported bottle of perfume','price'=>47.50),
        );
        $p1 = ProductFactory::createProducts($arr1);
    }
    public function testCreateProductWithArrayWithoutKeyQuantity(){
        $arr = array(
            'price'=>12.4,
            'description'=>'ako lng ni'
        );
        $prod = $this->obj->createProducts(array($arr));
        $this->assertContainsOnlyInstancesOf('Interfaces\ProductInterface', $prod);
    }
    public function testCreateOnlyProductsFromTestData(){
        $arr1 = array(
            array('quantity'=>1,'description'=>'imported box of chocolates','price'=>10.00),
            array('quantity'=>1,'description'=>'imported bottle of perfume','price'=>47.50),
        );
        $arr2 = array(
            array('quantity'=>1,'description'=>'book','price'=>12.49),
            array('quantity'=>1,'description'=>'music CD','price'=>14.99),
            array('quantity'=>1,'description'=>'chocolate bar','price'=>0.85)
        );
        $arr3 = array(
            array('quantity'=>1,'description'=>'imported bottle of perfume','price'=>27.99),
            array('quantity'=>1,'description'=>'bottle of perfume','price'=>18.99),
            array('quantity'=>1,'description'=>'packet of headache pills','price'=>9.75),
            array('quantity'=>1,'description'=>'box of imported chocolates','price'=>11.25),
        );
        $p1 = ProductFactory::createProducts($arr1);
        $p2 = ProductFactory::createProducts($arr2);
        $p3 = ProductFactory::createProducts($arr3);
        $mergedArr = array_merge($p1,$p2,$p3);
        $this->assertContainsOnlyInstancesOf('Interfaces\ProductInterface', $mergedArr);
    }

}
<?php
namespace Tests;
use Models\ProductFactory;
use Models\SalesTaxExemptProduct;
use Models\BasicProduct;

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
    public function testProductsCreatedEqualToTestData1(){
        $arr1 = array(
            array('quantity'=>1,'description'=>'book','price'=>12.49),
            array('quantity'=>1,'description'=>'music CD','price'=>14.99),
            array('quantity'=>1,'description'=>'chocolate bar','price'=>0.85)
        );
        $arr = array(
            new SalesTaxExemptProduct(12.49, 'book',false),
            new BasicProduct(14.99, 'music CD',false),
            new SalesTaxExemptProduct(0.85,'chocolate bar',false)
        );
        $p1 = ProductFactory::createProducts($arr1);
        $this->assertEquals($arr, $p1);

    }
    public function testProductsCreatedEqualToTestData2(){
        $arr1 = array(
            array('quantity'=>1,'description'=>'imported box of chocolates','price'=>10.00),
            array('quantity'=>1,'description'=>'imported bottle of perfume','price'=>47.50),
        );
        $arr = array(
            new SalesTaxExemptProduct(10.00, 'imported box of chocolates',true),
            new BasicProduct(47.50, 'imported bottle of perfume',true)
        );
        $p1 = ProductFactory::createProducts($arr1);
        $this->assertEquals($arr, $p1);

    }
    public function testProductsCreatedEqualToTestData3(){
        $arr1 = array(
            array('quantity'=>1,'description'=>'imported bottle of perfume','price'=>27.99),
            array('quantity'=>1,'description'=>'bottle of perfume','price'=>18.99),
            array('quantity'=>1,'description'=>'packet of headache pills','price'=>9.75),
            array('quantity'=>1,'description'=>'box of imported chocolates','price'=>11.25),
        );
        $arr = array(
            new BasicProduct(27.99, 'imported bottle of perfume',true),
            new BasicProduct(18.99, 'bottle of perfume',false),
            new SalesTaxExemptProduct(9.75, 'packet of headache pills',false),
            new SalesTaxExemptProduct(11.25, 'box of imported chocolates',true)
        );
        $p1 = ProductFactory::createProducts($arr1);
        $this->assertEquals($arr, $p1);

    }

}
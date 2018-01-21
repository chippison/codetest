<?php
namespace Tests;
use Models\Receipt;
use Models\SalesTaxExemptProduct;
use Models\BasicProduct;

class ReceiptTest extends \PHPUnit_Framework_TestCase{
    public function testConstructWithNull(){
        $this->expectException('TypeError');
        $r = new Receipt(null);
    }
    public function testConstructWithEmptyString(){
        $this->expectException('TypeError');
        $r = new Receipt('');
    }
    public function testConstructWithString(){
        $this->expectException('TypeError');
        $r = new Receipt('asd');
    }
    public function testPrintReceiptInput1(){
        $arr = array(
            new SalesTaxExemptProduct(12.49, 'book',false),
            new BasicProduct(14.99, 'music CD',false),
            new SalesTaxExemptProduct(0.85,'chocolate bar',false)
        );
        $r = new Receipt($arr);
        $printedReceipt = $r->printReceipt();
        $expectedOutput = '1 book: 12.49'.PHP_EOL.'1 music CD: 16.49'.PHP_EOL.'1 chocolate bar: 0.85'.PHP_EOL.'Sales Taxes: 1.50'.PHP_EOL.'Total: 29.83';
        $this->assertEquals($expectedOutput, $printedReceipt);
    }
    public function testPrintReceiptInput2(){
        $arr = array(
            new SalesTaxExemptProduct(10.00, 'imported box of chocolates',true),
            new BasicProduct(47.50, 'imported bottle of perfume',true)
        );
        $r = new Receipt($arr);
        $printedReceipt = $r->printReceipt();
        $expectedOutput = '1 imported box of chocolates: 10.50'.PHP_EOL.'1 imported bottle of perfume: 54.65'.PHP_EOL.'Sales Taxes: 7.65'.PHP_EOL.'Total: 65.15';
        $this->assertEquals($expectedOutput, $printedReceipt);
    }
    public function testPrintReceiptInput3(){
        $arr = array(
            new BasicProduct(27.99, 'imported bottle of perfume',true),
            new BasicProduct(18.99, 'bottle of perfume',false),
            new SalesTaxExemptProduct(9.75, 'packet of headache pills',false),
            new SalesTaxExemptProduct(11.25, 'box of imported chocolates',true)
        );
        $r = new Receipt($arr);
        $printedReceipt = $r->printReceipt();
        $expectedOutput = '1 imported bottle of perfume: 32.19'.PHP_EOL.'1 bottle of perfume: 20.89'.PHP_EOL.'1 packet of headache pills: 9.75'.PHP_EOL.'1 imported box of chocolates: 11.85'.PHP_EOL.'Sales Taxes: 6.70'.PHP_EOL.'Total: 74.68';
        $this->assertEquals($expectedOutput, $printedReceipt);
    }
}
<?php
require_once 'vendor/autoload.php';

use Models\Product;
use Models\SalesTaxExemptProduct;
use Models\ProductFactory;
use Models\Receipt;

$arr1 = array(
    array('quantity'=>1,'description'=>'book','price'=>12.49),
    array('quantity'=>1,'description'=>'music CD','price'=>14.99),
    array('quantity'=>1,'description'=>'chocolate bar','price'=>0.85)
);
$arr2 = array(
    array('quantity'=>1,'description'=>'imported box of chocolates','price'=>10.00),
    array('quantity'=>1,'description'=>'imported bottle of perfume','price'=>47.50),
);

$arr3 = array(
    array('quantity'=>1,'description'=>'imported bottle of perfume','price'=>27.99),
    array('quantity'=>1,'description'=>'bottle of perfume','price'=>18.99),
    array('quantity'=>1,'description'=>'packet of headache pills','price'=>9.75),
    array('quantity'=>1,'description'=>'box of imported chocolates','price'=>11.25),
);
$arrs1 = ProductFactory::createProducts($arr1);
//var_dump($arrs);
$receipt1 = new Receipt($arrs1);
$receiptOutput1 = $receipt1->printReceipt();
echo $receiptOutput1.PHP_EOL;

$arrs2 = ProductFactory::createProducts($arr2);
//var_dump($arrs);
$receipt2 = new Receipt($arrs2);
$receiptOutput2 = $receipt2->printReceipt();
echo $receiptOutput2.PHP_EOL;

$arrs3 = ProductFactory::createProducts($arr3);
//var_dump($arrs);
$receipt3 = new Receipt($arrs3);
$receiptOutput3 = $receipt3->printReceipt();
echo $receiptOutput3.PHP_EOL;


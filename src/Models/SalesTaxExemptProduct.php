<?php
namespace Models;
use Models\BasicProduct;
class SalesTaxExemptProduct extends Product{
    function __construct($grossPrice, $description, $isImported=false){
        $this->validateVariables($grossPrice, $description, $isImported);
        $this->salesTax = 0;
        $this->grossPrice = $grossPrice;
        $this->description = $description;
        $this->isImported = $isImported;
        $this->netPrice = $grossPrice;
    }
}
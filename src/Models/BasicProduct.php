<?php
namespace Models;
use Interfaces\ProductInterface;
class BasicProduct extends Product{
    function __construct($grossPrice,$description,$isImported=false){
        $this->validateVariables($grossPrice, $description, $isImported);
        $this->salesTax = .1;
        $this->grossPrice = $grossPrice;
        $this->description = $description;
        $this->isImported = $isImported;
        $this->netPrice = $grossPrice;
    }

}
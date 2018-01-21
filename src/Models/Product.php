<?php
namespace Models;
use Interfaces\ProductInterface;

abstract class Product implements ProductInterface{
    protected $salesTax;
    protected $grossPrice;    // price before tax
    protected $netPrice; //price after tax
    protected $description;
    protected $isImported;
    protected $importTax = 0.05;

    public function computeNetPrice(){
        $this->netPrice = $this->grossPrice+$this->getTaxesPaid();
        return round($this->netPrice,2);
    }
    public function getTaxesPaid(){
        $tax = $this->getTotalTaxToAdd();
        if($tax == 0) return 0;
        $totalPaid = ($tax*$this->grossPrice);
        return $this->roundSalesTax($totalPaid);
    }
    public function getDescription(){
        return $this->description;
    }
    public function isImported(){
        return $this->isImported;
    }
    public function validateVariables($grossPrice, $description, $isImported){
        if($grossPrice=='' || $grossPrice == null || !is_numeric($grossPrice)) throw new \Exception();
        if($description=='' || $description == null) throw new \Exception();
        if(!is_bool($isImported)) throw new \Exception();
    }
    private function roundSalesTax($n,$x=.05){
        if(!is_numeric($n)) throw new \Exception();
        return ceil($n/$x)*$x;
    }
    private function getTotalTaxToAdd(){
        $tax = $this->salesTax;
        if($this->isImported) $tax = $tax + $this->importTax;
        return $tax;
    }
}
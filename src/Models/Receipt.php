<?php
namespace Models;
use Interfaces\ProductInterface;

class Receipt{
    private $items;
    function __construct(array $items){
        $this->items = $items;
    }
    public function printReceipt(){
        $totalPrice = $totalTax = 0;
        $desc = '';
        foreach ($this->items as $i){
            if($i instanceof ProductInterface){
                $netPrice = $i->computeNetPrice();
                $totalPrice += $netPrice;
                $totalTax +=$i->getTaxesPaid();
                $desc .= $this->formatDescription($i);
                continue;
            }
        }
        $output =  $desc.'Sales Taxes: '.number_format($totalTax,2).PHP_EOL.'Total: '.number_format($totalPrice,2);
        return $output;
    }
    private function formatDescription(ProductInterface $i){
        $description = $i->getDescription();
        $desc = $description;
        if($i->isImported()) $desc = $this->formatDescriptionOfImportedItem($description);
        $netPrice = $i->computeNetPrice();
        return '1 '.$desc.': '.number_format($netPrice,2).PHP_EOL;
    }
    private function formatDescriptionOfImportedItem($description){
        $description = str_replace('imported ', '', $description);
        $description = 'imported '.$description;
        return $description;
    }
}
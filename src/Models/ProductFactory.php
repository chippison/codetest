<?php
namespace Models;
class ProductFactory{
    public function createProducts($arr){
        if(!is_array($arr)) throw new \Exception();
        $productArr = array();
        foreach ($arr as $a){
            $q = 1;
            if(!array_key_exists('description', $a)) throw new \Exception();
            if(!array_key_exists('price', $a)) throw new \Exception();
            if(isset($a['quantity'])) $q = $a['quantity'];
            $description = $a['description'];
            $descArr = explode(' ',$description);
            $isImported = ProductFactory::checkIfImported($description);
            if(ProductFactory::isProductExcempt($descArr)){
                $product = new SalesTaxExemptProduct($a['price'], $description, $isImported);
            }else{
                $product = new BasicProduct($a['price'], $description, $isImported);
            }
            for($i=0;$i<$a['quantity'];$i++){
                $productArr[] = $product;
            }
        }
        return $productArr;
    }
    private function checkIfImported($description){
        $descArr = explode(' ',strtolower($description));
        if(in_array('imported',$descArr)) return true;
        return false;
    }
    //uses a static list of excempted products...
    //based the list on the examples given
    private function isProductExcempt($descArr){
        $excemptProducts = array('book','chocolates','chocolate','headache','pills');
        foreach ($excemptProducts as $e){
            if(in_array($e,$descArr)){
                return true;
            }
        }
        return false;
    }
}
<?php
namespace Interfaces;
interface ProductInterface{
    public function computeNetPrice();
    public function getTaxesPaid();
    public function getDescription();
    public function isImported();
}
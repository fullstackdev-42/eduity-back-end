<?php
namespace App\IO\ItemConverter;

interface ItemConverterInterface  {
    public function convert(array $item);
}
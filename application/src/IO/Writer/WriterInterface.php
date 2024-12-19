<?php
namespace App\IO\Writer;

interface WriterInterface {
    public function prepare();
    public function writeItem(array $item, array $originalItem);
    public function finish();
    public function getErrors() : array;
}
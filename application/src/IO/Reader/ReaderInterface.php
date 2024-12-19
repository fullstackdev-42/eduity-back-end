<?php
namespace App\IO\Reader;

interface ReaderInterface extends \Iterator, \Countable {
    /**
     * Get field (header) names
     * 
     * @return string[]
     */
    public function getFieldNames() : array;
    public function setFieldNames(array $fieldNames);
    public function getErrors() : array;
    public function prepare();
    public function finish();
}
<?php
namespace App\IO\Reader;

abstract class AbstractReader implements ReaderInterface {

    protected $count;
    protected $fieldsNames;
    protected $errors = [];

    public function getErrors() : array {
        return $this->errors;
    }

    public function getFieldNames() : array {
        return $this->fieldsNames;
    }

    public function setFieldNames(array $fieldsNames = []) : self {
        $this->fieldsNames = $fieldsNames;
        
        return $this;
    }

    public function count() : int {
        if ($this->count === null) {
            $this->count = 0;
            foreach ($this as $row) {
                $this->count++;
            }
        }

        return $this->count;
    }

    public function finish() : self {
        return $this;
    }

}
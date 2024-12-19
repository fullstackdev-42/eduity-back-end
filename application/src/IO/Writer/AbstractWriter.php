<?php
namespace App\IO\Writer;

abstract class AbstractWriter implements WriterInterface {
    protected $errors = [];

    public function getErrors() : array {
        return $this->errors;
    }

    public function finish() : self {
        return $this;
    }
}
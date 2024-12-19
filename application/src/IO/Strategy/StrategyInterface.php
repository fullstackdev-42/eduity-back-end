<?php
namespace App\IO\Strategy;

interface StrategyInterface
{
    public function setObject(object $object);
    public function getObject() : object;
    public function getClassName() : string;
    public function addIgnoredMethodName(string $name);
    public function removeIgnoredMethodName(string $name);
    public function getFields() : array;
    public function toArray() : array;
}

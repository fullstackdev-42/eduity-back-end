<?php
namespace App\IO\Strategy;

use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class AbstractStrategy implements StrategyInterface {
    protected $object;
    protected $fields;
    protected $ignoreMethodNames = ['getClassName', 'getObject', 'getFields'];

    protected function createInstance() : object {
        $className = $this->getClassName();
        if (!class_exists($className)) {
            throw new \RuntimeException("'$className' is not a valid class name");
        }

        return new $className();
    }

    public function setObject(object $object) : self {
        if (get_class($object) !== $this->getClassName()) {
            throw new \InvalidArgumentException('Parameter $object must be an instance of class "'. 
                $this->getClassName() .'". Object supplied is instance of "'. get_class($object) .'"');
        }
        $this->object = $object;


        return $this;
    }

    public function getObject() : object {
        if ($this->object === null) {
            $this->object = $this->createInstance();
        }

        return $this->object;
    }

    public function getClassName() : string {
        return $this->className;
    }

    public function addIgnoredMethodName(string $name) : self {
        if (!in_array($name, $this->ignoreMethodNames)) {
            $this->ignoreMethodNames[] = $name;
        }

        return $this;
    }

    public function removeIgnoredMethodName(string $name) : self {
        $key = array_search($name, $this->ignoreMethodNames);
        if ($key !== false) {
            unset($this->ignoreMethodNames[$key]);
        }

        return $this;
    }

    public function getFields() : array {
        //build fields if we haven't already
        if ($this->fields === null) {
            $this->fields = [];
            $reflectionObj = new \ReflectionObject($this);
            $reflectionMethods = $reflectionObj->getMethods(\ReflectionMethod::IS_PUBLIC);

            foreach ($reflectionMethods as $method) {
                //if getter and not in ignoremethods array, add to our fields array
                if ($this->isGetMethod($method) && !in_array($method->name, $this->ignoreMethodNames)) {
                    //remove the "get" from the name
                    $fieldName = lcfirst(substr($method->name, 3));

                    $this->fields[$fieldName] = $fieldName;
                }
            }
        }

        return $this->fields;
    }

    public function toArray() : array {
        $array = [];
        $fields = $this->getFields();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($fields as $field) {
            $array[$field] = $propertyAccessor->getValue($this, $field);
        }

        return $array;
    }

    /**
     * Returns true if method is a getter method without any required arguments
     * @return boolean
     */
    private function isGetMethod(\ReflectionMethod $method)
    {
        return
            (strpos($method->name, 'get') === 0 &&
            strlen($method->name) > 3 &&
            $method->getNumberOfRequiredParameters() === 0);
    }

}
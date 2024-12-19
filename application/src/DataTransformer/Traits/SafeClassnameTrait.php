<?php

namespace App\DataTransformer\Traits;

trait SafeClassnameTrait
{

    /**
     * Return the FQCN the class if set in the parameters
     */
    private function verifyClassname($classname, $parameterName) {
        $classname = strtolower($classname);
        $classes = $this->paramsBag->get($parameterName);
        foreach ($classes as $class) {
            if (strpos(strtolower($class), $classname) !== false) {
                return $class;
            }
        }
        return null;
    }

    private function getSafeClassName($classname): String {
        return substr($classname, strrpos($classname, '/',-1) + 1);
    }

}
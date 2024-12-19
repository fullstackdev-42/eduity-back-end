<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Utils;

use Doctrine\Common\Persistence\Proxy;

/**
 * Class related functionality for objects that might or not be proxy objects at the moment.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ClassUtils
{
    /**
     * Gets the real class name of a class name that could be a proxy.
     *
     * @param string $class The class name
     *
     * @return string
     */
    public static function getRealClass(string $class): string
    {
        if (false === $pos = strrpos($class, '\\'.Proxy::MARKER.'\\')) {
            return $class;
        }

        return substr($class, $pos + Proxy::MARKER_LENGTH + 2);
    }

    /**
     * Gets the real class name of an object.
     *
     * @param object $object The object
     *
     * @return string
     */
    public static function getClass($object): string
    {
        return self::getRealClass(\get_class($object));
    }
}

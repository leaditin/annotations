<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Exception;

/**
 * Class ReflectionException
 *
 * @package Leaditin\Annotations\Exception
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class ReflectionException extends \LogicException
{
    /**
     * @param string $method
     * @return ReflectionException
     */
    public static function undefinedMethodAnnotations(string $method) : ReflectionException
    {
        return new self(sprintf(
            'Undefined annotations for method "%s"',
            $method
        ));
    }

    /**
     * @param string $property
     * @return ReflectionException
     */
    public static function undefinedPropertyAnnotations(string $property) : ReflectionException
    {
        return new self(sprintf(
            'Undefined annotations for property "%s"',
            $property
        ));
    }
}

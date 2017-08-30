<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Exception;

/**
 * Class CollectionException
 *
 * @package Leaditin\Annotations\Exception
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class CollectionException extends \LogicException
{
    /**
     * @param string $name
     * @return CollectionException
     */
    public static function undefinedAnnotation(string $name) : CollectionException
    {
        return new self(sprintf(
            'Trying to retrieve undefined annotation "%s" in collection',
            $name
        ));
    }
}

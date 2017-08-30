<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Exception;

/**
 * Class ReaderException
 *
 * @package Leaditin\Annotations\Exception
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class ReaderException extends \LogicException
{
    /**
     * @param string $class
     * @param \Exception $previous
     * @return ReaderException
     */
    public static function unableToReadClass(string $class, \Exception $previous) : ReaderException
    {
        return new self(
            sprintf('Unable to read class "%s"', $class),
            0,
            $previous
        );
    }
}

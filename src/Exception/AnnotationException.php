<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Exception;

use Leaditin\Annotations\Annotation;

/**
 * Class AnnotationException
 *
 * @package Leaditin\Annotations\Exception
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class AnnotationException extends \LogicException
{
    /**
     * @param Annotation $annotation
     * @param string $argument
     * @return AnnotationException
     */
    public static function undefinedArgument(Annotation $annotation, string $argument) : AnnotationException
    {
        return new self(sprintf(
            'Annotation for "%s" does not have argument "%s"',
            $annotation->getName(),
            $argument
        ));
    }
}

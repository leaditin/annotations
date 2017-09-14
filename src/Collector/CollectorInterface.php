<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Collector;

use Leaditin\Annotations\Exception\ReaderException;
use Leaditin\Annotations\Reflection;

/**
 * Interface CollectorInterface
 *
 * @package Leaditin\Annotations\Collector
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
interface CollectorInterface
{
    /**
     * @param string $class
     * @return Reflection
     * @throws ReaderException
     */
    public function read(string $class) : Reflection;
}

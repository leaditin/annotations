<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Reader;

use Leaditin\Annotations\Reflection;

/**
 * Interface ReaderInterface
 *
 * @package Leaditin\Annotations\Reader
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
interface ReaderInterface
{
    /**
     * @param string $class
     * @return Reflection
     */
    public function read(string $class) : Reflection;
}

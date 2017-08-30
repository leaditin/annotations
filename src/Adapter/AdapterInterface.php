<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Adapter;

use Leaditin\Annotations\Exception\ReaderException;
use Leaditin\Annotations\Reflection;

/**
 * Interface AdapterInterface
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
interface AdapterInterface
{
    /**
     * @param string $class
     * @return Reflection
     * @throws ReaderException
     */
    public function read(string $class) : Reflection;
}

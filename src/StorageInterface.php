<?php

declare(strict_types = 1);

namespace Leaditin\Annotations;

use Leaditin\Annotations\Exception\ReaderException;
use Leaditin\Annotations\Exception\StorageException;

/**
 * Interface StorageInterface
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
interface StorageInterface
{
    /**
     * @param string $class
     * @return Reflection
     * @throws ReaderException|StorageException
     */
    public function read(string $class) : Reflection;
}

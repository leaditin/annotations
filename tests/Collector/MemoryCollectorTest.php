<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests\Collector;

use Leaditin\Annotations\Reader\ReflectionReader;
use Leaditin\Annotations\Reflection;
use Leaditin\Annotations\Collector\MemoryCollector;
use Leaditin\Annotations\Tests\Assets\User;
use PHPUnit\Framework\TestCase;

/**
 * Class MemoryCollectorTest
 *
 * @package Leaditin\Annotations\Tests\Collector
 * @author Igor Vuckovic
 */
class MemoryCollectorTest extends TestCase
{
    public function testRead()
    {
        $storage = new MemoryCollector(new ReflectionReader());
        $reflection = $storage->read(User::class);

        self::assertInstanceOf(Reflection::class, $reflection);
    }
}

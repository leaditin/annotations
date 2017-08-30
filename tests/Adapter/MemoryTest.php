<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests\Adapter;

use Leaditin\Annotations\Reader\ReflectionReader;
use Leaditin\Annotations\Reflection;
use Leaditin\Annotations\Adapter\MemoryAdapter;
use Leaditin\Annotations\Tests\Assets\User;
use PHPUnit\Framework\TestCase;

/**
 * Class MemoryTest
 *
 * @package Leaditin\Annotations\Tests\Adapter
 * @author Igor Vuckovic
 */
class MemoryTest extends TestCase
{
    public function testWrite()
    {
        $storage = new MemoryAdapter(new ReflectionReader());
        $reflection = $storage->read(User::class);

        self::assertInstanceOf(Reflection::class, $reflection);
    }
}

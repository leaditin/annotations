<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests\Storage;

use Leaditin\Annotations\Reflection;
use Leaditin\Annotations\Storage\Memory;
use Leaditin\Annotations\Tests\Assets\User;
use PHPUnit\Framework\TestCase;

/**
 * Class MemoryTest
 *
 * @package Leaditin\Annotations\Tests\Storage
 * @author Igor Vuckovic
 */
class MemoryTest extends TestCase
{
    public function testWrite()
    {
        $storage = new Memory();
        $reflection = $storage->read(User::class);

        self::assertInstanceOf(Reflection::class, $reflection);
    }
}

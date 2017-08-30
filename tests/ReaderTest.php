<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests;

use Leaditin\Annotations\Collection;
use Leaditin\Annotations\Exception\CollectionException;
use Leaditin\Annotations\Exception\ReaderException;
use Leaditin\Annotations\Exception\ReflectionException;
use Leaditin\Annotations\Reader;
use Leaditin\Annotations\Tests\Assets\Role;
use Leaditin\Annotations\Tests\Assets\User;
use PHPUnit\Framework\TestCase;

/**
 * Class ReaderTest
 *
 * @package Leaditin\Annotations\Tests
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class ReaderTest extends TestCase
{
    public function testParseThrowsException()
    {
        $this->expectException(ReaderException::class);
        $this->expectExceptionMessage('Unable to read class "Leaditin"');

        $reader = new Reader();
        $reader->parse('Leaditin');
    }

    public function testParseClassAnnotations()
    {
        $reader = new Reader();
        $reflection = $reader->parse(User::class);
        $classAnnotations = $reflection->getClassAnnotations();

        self::assertCount(2, $classAnnotations);
        self::assertInstanceOf(Collection::class, $classAnnotations);
    }

    public function testParseMethodAnnotations()
    {
        $reader = new Reader();
        $reflection = $reader->parse(User::class);
        $methodAnnotations = $reflection->getMethodAnnotations('setRole');

        self::assertInstanceOf(Collection::class, $methodAnnotations);
        self::assertTrue($methodAnnotations->has('param'));
        self::assertContains(Role::class, $methodAnnotations->findOne('param')->getArgument(0));
    }

    public function testParseMethodReadReturn()
    {
        $reader = new Reader();
        $reflection = $reader->parse(User::class);
        $methodAnnotations = $reflection->getMethodAnnotations('setRole');

        self::assertInstanceOf(Collection::class, $methodAnnotations);
        self::assertTrue($methodAnnotations->has('return'));
        self::assertSame(User::class, $methodAnnotations->findOne('return')->getArgument(0));
    }

    public function testParseMethodReadThrows()
    {
        $reader = new Reader();
        $reflection = $reader->parse(User::class);
        $methodAnnotations = $reflection->getMethodAnnotations('throwException');

        self::assertInstanceOf(Collection::class, $methodAnnotations);
        self::assertTrue($methodAnnotations->has('throws'));
        self::assertSame(\LogicException::class, $methodAnnotations->findOne('throws')->getArgument(0));
        self::assertSame(ReflectionException::class, $methodAnnotations->findOne('throws')->getArgument(1));
        self::assertSame(CollectionException::class, $methodAnnotations->findOne('throws')->getArgument(2));
    }

    public function testParsePropertyAnnotations()
    {
        $reader = new Reader();
        $reflection = $reader->parse(User::class);
        $propertyAnnotations = $reflection->getPropertyAnnotations('id');

        self::assertInstanceOf(Collection::class, $propertyAnnotations);
        self::assertTrue($propertyAnnotations->has('Identity'));
        self::assertSame('id', $propertyAnnotations->findOne('Column')->getArgument('column'));
    }
}

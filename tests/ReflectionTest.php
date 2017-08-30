<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests;

use Leaditin\Annotations\Annotation;
use Leaditin\Annotations\Collection;
use Leaditin\Annotations\Exception\ReflectionException;
use Leaditin\Annotations\Reflection;
use PHPUnit\Framework\TestCase;

/**
 * Class ReflectionTest
 *
 * @package Leaditin\Annotations\Tests
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class ReflectionTest extends TestCase
{
    /** @var Reflection */
    private $reflection;

    protected function setUp()
    {
        $this->reflection = new Reflection(
            new Collection(
                new Annotation('author', ['Igor Vuckovic'])
            ),
            [
                'getId' => new Collection(
                    new Annotation('return', ['int'])
                )
            ],
            [
                'id' => new Collection(
                    new Annotation('source', ['users'])
                )
            ]
        );
    }

    protected function tearDown()
    {
        unset($this->reflection);
    }

    public function testGetClassAnnotations()
    {
        $collection = $this->reflection->getClassAnnotations();

        self::assertInstanceOf(Collection::class, $collection);
    }

    public function testGetAllMethodAnnotations()
    {
        $allCollection = $this->reflection->getMethodsAnnotations();
        self::assertCount(1, $allCollection);

        $collection = current($allCollection);
        self::assertInstanceOf(Collection::class, $collection);
    }

    public function testGetAllPropertyAnnotations()
    {
        $allCollection = $this->reflection->getPropertiesAnnotations();
        self::assertCount(1, $allCollection);

        $collection = current($allCollection);
        self::assertInstanceOf(Collection::class, $collection);
    }

    public function testGetMethodAnnotations()
    {
        $collection = $this->reflection->getMethodAnnotations('getId');

        self::assertCount(1, $collection);
        self::assertInstanceOf(Collection::class, $collection);
    }

    public function testGetMethodAnnotationsThrowsException()
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionMessage('Undefined annotations for method "undefined"');
        $this->reflection->getMethodAnnotations('undefined');
    }

    public function testGetPropertyAnnotations()
    {
        $collection = $this->reflection->getPropertyAnnotations('id');

        self::assertCount(1, $collection);
        self::assertInstanceOf(Collection::class, $collection);
    }

    public function testGetPropertyAnnotationsThrowsException()
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionMessage('Undefined annotations for property "undefined"');
        $this->reflection->getPropertyAnnotations('undefined');
    }
}

<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests;

use Leaditin\Annotations\Annotation;
use Leaditin\Annotations\Exception\AnnotationException;
use PHPUnit\Framework\TestCase;

/**
 * Class AnnotationTest
 *
 * @package Leaditin\Annotations\Tests
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class AnnotationTest extends TestCase
{
    /**
     * @return array
     */
    public function nameProvider() : array
    {
        return [
            ['Column'],
            ['property'],
            ['var'],
        ];
    }

    /**
     * @param string $name
     * @dataProvider nameProvider
     */
    public function testGetName(string $name)
    {
        $annotation = new Annotation($name, []);

        self::assertSame($name, $annotation->getName());
    }

    /**
     * @return array
     */
    public function argumentsProvider() : array
    {
        return [
            [
                ['userId', 'User', 'id']
            ],
            [
                ['column' => 'id']
            ],
        ];
    }

    /**
     * @param array $arguments
     * @dataProvider argumentsProvider
     */
    public function testGetArguments(array $arguments)
    {
        $annotation = new Annotation('Column', $arguments);

        self::assertSame($arguments, $annotation->getArguments());
    }

    public function testHasArgument()
    {
        $annotation = new Annotation('Column', ['column' => 'user_id']);

        self::assertTrue($annotation->hasArgument('column'));
    }

    public function testGetArgument()
    {
        $annotation = new Annotation('Column', ['column' => 'user_id']);

        self::assertSame('user_id', $annotation->getArgument('column'));
    }

    public function testGetArgumentThrowsException()
    {
        $annotation = new Annotation('Column', []);

        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessage('Annotation for "Column" does not have argument "user_id"');

        $annotation->getArgument('user_id');
    }
}

<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests;

use Leaditin\Annotations\Annotation;
use Leaditin\Annotations\Collection;
use Leaditin\Annotations\Exception\CollectionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CollectionTest
 *
 * @package Leaditin\Collections\Tests
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class CollectionTest extends TestCase
{
    public function testGetIterator()
    {
        $collection = new Collection();

        self::assertInstanceOf(\ArrayIterator::class, $collection->getIterator());
    }

    public function testCount()
    {
        $collection = new Collection(
            new Annotation('Identity', []),
            new Annotation('Primary', []),
            new Annotation('Column', ['column' => 'id'])
        );

        self::assertCount(3, $collection);
    }

    public function testGetAll()
    {
        $collection = new Collection(
            new Annotation('Identity', []),
            new Annotation('Primary', []),
            new Annotation('Column', ['column' => 'id'])
        );

        $annotations = $collection->getAll();

        self::assertCount(3, $annotations);
    }

    public function testHas()
    {
        $collection = new Collection(
            new Annotation('Column', ['column' => 'id'])
        );

        self::assertTrue($collection->has('Column'));
    }

    public function testHasNot()
    {
        $collection = new Collection(
            new Annotation('Column', ['column' => 'id'])
        );

        self::assertFalse($collection->has('Identity'));
    }

    public function testFindOne()
    {
        $collection = new Collection(
            new Annotation('Column', ['column' => 'id'])
        );

        $annotation = $collection->findOne('Column');

        self::assertInstanceOf(Annotation::class, $annotation);
        self::assertSame('Column', $annotation->getName());
    }

    public function testFindOneThrowsException()
    {
        $collection = new Collection(
            new Annotation('Column', ['column' => 'id'])
        );

        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage('Trying to retrieve undefined annotation "Identity" in collection');

        $collection->findOne('Identity');
    }

    public function testFind()
    {
        $collection = new Collection(
            new Annotation('Column', ['column' => 'id']),
            new Annotation('Column', ['nullable' => false])
        );

        $annotations = $collection->find('Column');

        self::assertInstanceOf(Collection::class, $annotations);
        self::assertCount(2, $collection);
    }
}

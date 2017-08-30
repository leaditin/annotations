<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests;

use Leaditin\Annotations\Exception\CollectionException;
use Leaditin\Annotations\Exception\ReflectionException;
use Leaditin\Annotations\Tests\Assets\Role;
use Leaditin\Annotations\Tests\Assets\User;
use Leaditin\Annotations\Tokenizer;
use PHPUnit\Framework\TestCase;

/**
 * Class TokenizerTest
 *
 * @package Leaditin\Annotations\Tests
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class TokenizerTest extends TestCase
{
    /** @var Tokenizer */
    private $tokenizer;

    protected function setUp()
    {
        $this->tokenizer = new Tokenizer(
            new \ReflectionClass(User::class)
        );
    }

    protected function tearDown()
    {
        unset($this->tokenizer);
    }

    public function testUseClassAsAlias()
    {
        $this->assertSame(CollectionException::class, $this->tokenizer->getFullyQualifiedClassName('Alias'));
    }

    public function testUseClass()
    {
        $this->assertSame(ReflectionException::class, $this->tokenizer->getFullyQualifiedClassName('ReflectionException'));
    }

    public function testUseClassFromSameNamespace()
    {
        $this->assertSame(Role::class, $this->tokenizer->getFullyQualifiedClassName('Role'));
    }

    public function testNotInUseClass()
    {
        $this->assertSame('ReflectionTest', $this->tokenizer->getFullyQualifiedClassName('ReflectionTest'));
        $this->assertSame('int', $this->tokenizer->getFullyQualifiedClassName('int'));
    }
}

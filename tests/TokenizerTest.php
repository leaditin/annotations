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

    public function testResolveClassNameFromAlias()
    {
        $this->assertSame(CollectionException::class, $this->tokenizer->resolveFullyQualifiedClassName('Alias'));
    }

    public function testResolveClassNameFromFullyQualifiedName()
    {
        $this->assertSame(ReflectionException::class, $this->tokenizer->resolveFullyQualifiedClassName('ReflectionException'));
    }

    public function testResolveClassNameFromSameNamespace()
    {
        $this->assertSame(Role::class, $this->tokenizer->resolveFullyQualifiedClassName('Role'));
    }

    public function testResolveClassNameFromName()
    {
        $this->assertSame('ReflectionTest', $this->tokenizer->resolveFullyQualifiedClassName('ReflectionTest'));
    }

    public function testResolveVariableName()
    {
        $this->assertSame('int', $this->tokenizer->resolveVariableName('int'));
    }
}

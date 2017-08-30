<?php

declare(strict_types = 1);

namespace Leaditin\Annotations;

/**
 * Class Tokenizer
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic
 */
class Tokenizer
{
    /** @var \ReflectionClass */
    protected $reflectionClass;

    /** @var array */
    protected $tokens;

    /** @var array */
    protected $structure;

    /**
     * @param \ReflectionClass $reflectionClass
     */
    public function __construct(\ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
        $this->tokens = token_get_all(file_get_contents($this->reflectionClass->getFileName()));
        $this->structure = [];
    }

    /**
     * @param string $name
     * @return string
     */
    public function getFullyQualifiedClassName(string $name) : string
    {
        if ($this->isScalar($name)) {
            return $name;
        }

        if ($this->isSelf($name)) {
            return $this->trimClassName($this->reflectionClass->getName());
        }

        $length = strlen($name);

        foreach ($this->getUseNames() as $fullyQualifiedClassName => $useClassName) {
            if (substr($useClassName, -$length) === $name) {
                return $fullyQualifiedClassName;
            }
        }

        if (0 !== strpos($name, '\\')) {
            $fullyQualifiedClassName = "{$this->reflectionClass->getNamespaceName()}\\$name";
            if (class_exists($fullyQualifiedClassName)) {
                return $this->trimClassName($fullyQualifiedClassName);
            }
        }

        return $this->trimClassName($name);
    }

    /**
     * @return array
     */
    protected function getUseNames() : array
    {
        if (!array_key_exists('use', $this->structure)) {
            $class = '';
            $numberOfTokens = count($this->tokens);
            $this->structure['use'] = [];

            for ($i = 0; $i < $numberOfTokens; ++$i) {
                if ($this->tokens[$i][0] !== T_USE) {
                    continue;
                }

                for ($j = $i + 1; $j < $numberOfTokens; ++$j) {
                    if ($this->tokens[$j][0] === T_STRING) {
                        $class .= '\\' . $this->tokens[$j][1];
                        continue;
                    }

                    if ($this->tokens[$j] === ';') {
                        $fullyQualifiedClassName = $this->deriveFullyQualifiedClassName($class);
                        $this->structure['use'][$this->trimClassName($fullyQualifiedClassName)] = $this->trimClassName($class);
                        $class = '';
                        break;
                    }
                }
            }
        }

        return $this->structure['use'];
    }

    /**
     * @param string $className
     * @return bool|string
     */
    protected function deriveFullyQualifiedClassName(string $className) : string
    {
        while (!class_exists($className)) {
            $length = strrpos($className, '\\');
            $className = substr($className, 0, $length);
        }

        return $className;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function isScalar(string $name) : bool
    {
        $scalars = [
            'int', 'integer',
            'bool', 'boolean',
            'string', 'array',
            'float', 'double', 'decimal',
        ];

        return in_array($name, $scalars, false);
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function isSelf(string $name) : bool
    {
        $selves = [
            'self',
            'static',
            '$this'
        ];

        return in_array($name, $selves, false);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function trimClassName(string $name) : string
    {
        return ltrim($name, '\\');
    }
}

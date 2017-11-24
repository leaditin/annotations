<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Reader;

use Leaditin\Annotations\Annotation;
use Leaditin\Annotations\Collection;
use Leaditin\Annotations\Exception\ReaderException;
use Leaditin\Annotations\Reflection;
use Leaditin\Annotations\Tokenizer;

/**
 * Class ReflectionReader
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class ReflectionReader implements ReaderInterface
{
    /** @var \ReflectionClass */
    protected $reflectionClass;

    /** @var Tokenizer */
    protected $tokenizer;

    /**
     * @param string $class
     * @return Reflection
     * @throws ReaderException
     */
    public function read(string $class) : Reflection
    {
        try {
            $this->reflectionClass = new \ReflectionClass($class);
            $this->tokenizer = new Tokenizer($this->reflectionClass);

            return new Reflection(
                $this->readAnnotationsFromClass(),
                $this->readAnnotationsFromMethods(),
                $this->readAnnotationsFromProperties()
            );
        } catch (\ReflectionException $ex) {
            throw ReaderException::unableToReadClass($class, $ex);
        }
    }

    /**
     * @return Collection
     */
    protected function readAnnotationsFromClass() : Collection
    {
        $collection = $this->parseComment($this->reflectionClass->getDocComment());

        return new Collection(...$collection);
    }

    /**
     * @return array|Collection[]
     */
    protected function readAnnotationsFromMethods() : array
    {
        $annotationsFromMethods = [];
        foreach ($this->reflectionClass->getMethods() as $method) {
            $methodCollection = $this->parseComment($method->getDocComment());
            if (empty($methodCollection)) {
                continue;
            }

            $annotationsFromMethods[$method->name] = new Collection(...$methodCollection);
        }

        return $annotationsFromMethods;
    }

    /**
     * @return array|Collection[]
     */
    protected function readAnnotationsFromProperties() : array
    {
        $annotationsFromProperties = [];
        foreach ($this->reflectionClass->getProperties() as $property) {
            $propertyCollection = $this->parseComment($property->getDocComment());
            if (empty($propertyCollection)) {
                continue;
            }

            $annotationsFromProperties[$property->name] = new Collection(...$propertyCollection);
        }

        return $annotationsFromProperties;
    }

    /**
     * @param string|bool $comment
     * @return array|Annotation[]
     */
    protected function parseComment($comment = false) : array
    {
        $annotations = [];

        if ($comment === false) {
            return $annotations;
        }

        preg_match_all('/@([^*]+)/', $comment, $matches);
        foreach ($matches[1] as $match) {
            $annotations[] = $this->parseLine($match);
        }

        return $annotations;
    }

    /**
     * @param string $line
     * @return bool|Annotation
     */
    protected function parseLine(string $line)
    {
        preg_match('/^(\w+)(\(.+\)|\s+.+\n*|\}?)/', $line, $matches);
        $name = $matches[1];
        $arguments = $this->parseArgumentsFromLine($matches[2] ?: '');
        $this->filterArguments($name, $arguments);

        return new Annotation($name, $arguments);
    }

    /**
     * @param string $line
     * @return array
     */
    protected function parseArgumentsFromLine(string $line) : array
    {
        $line = preg_replace('/^\((.*?)\)$/', '$1', trim($line));
        $arguments = [];

        if ($line === '') {
            return $arguments;
        }

        $data = $this->exportArgumentsFromLine($line);
        foreach ($data as $index => $property) {
            $properties = explode('=', $property, 2);
            if (count($properties) === 1) {
                $arguments[$index] = $this->filterValue($property);
            } else {
                $arguments[$this->filterName($properties[0])] = $this->filterValue($properties[1]);
            }
        }

        return $arguments;
    }

    /**
     * @param string $line
     * @return array
     */
    protected function exportArgumentsFromLine(string $line) : array
    {
        if (false !== strpos($line, '|')) {
            return explode('|', $line);
        }

        return explode(',', $line);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function filterName(string $name) : string
    {
        return preg_replace_callback('/^"([^"]*)"$|^\'([^\']*)\'$/', function ($matches) {
            return $matches[2] ?? $matches[1];
        }, trim($name));
    }

    /**
     * @param string $value
     * @return int|string|bool|float|array
     */
    protected function filterValue(string $value)
    {
        $value = $this->filterName($value);
        $data = json_decode(str_replace('\'', '"', $value), true);

        return $data ?? $value;
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    protected function filterArguments(string $name, array &$arguments)
    {
        $allowed = [
            'var', 'param', 'property', 'method', 'return', 'throws',
        ];

        if (!in_array($name, $allowed, false)) {
            return;
        }

        array_walk($arguments, function (&$val) {
            $val = preg_replace('/(\$\w+)$/', '', $val);
            $val = trim($val);
            $val = $this->tokenizer->resolveVariableName($val);
            $val = $this->tokenizer->resolveFullyQualifiedClassName($val);
        });
    }
}

<?php

declare(strict_types = 1);

namespace Leaditin\Annotations;

use Leaditin\Annotations\Exception\ReaderException;

/**
 * Class Reader
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class Reader
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
    public function parse(string $class) : Reflection
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
        $annotations = [];
        foreach ($this->reflectionClass->getMethods() as $method) {
            $collection = $this->parseComment($method->getDocComment());
            if (empty($collection)) {
                continue;
            }

            $annotations[$method->getName()] = new Collection(...$collection);
        }

        return $annotations;
    }

    /**
     * @return array|Collection[]
     */
    protected function readAnnotationsFromProperties() : array
    {
        $annotations = [];
        foreach ($this->reflectionClass->getProperties() as $property) {
            $collection = $this->parseComment($property->getDocComment());
            if (empty($collection)) {
                continue;
            }

            $annotations[$property->getName()] = new Collection(...$collection);
        }

        return $annotations;
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
     * @return Annotation
     */
    protected function parseLine(string $line) : Annotation
    {
        preg_match('/(\w+)[\s|\(]*([^\)]*)/', $line, $matches);
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
        $line = trim($line);
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
            @list(, $singleQuoted, $doubleQuoted) = $matches;

            return strlen($singleQuoted) ? $singleQuoted : $doubleQuoted;
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
        switch ($name) {
            case 'var':
            case 'param':
            case 'property':
            case 'method':
            case 'return':
            case 'throws':
                array_walk($arguments, function (&$val) {
                    $val = preg_replace('/(\$\S+)/', '', $val);
                    $val = trim($val);
                    $val = $this->tokenizer->getFullyQualifiedClassName($val);
                });
                break;
        }
    }
}

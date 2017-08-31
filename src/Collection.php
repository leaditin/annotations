<?php

declare(strict_types = 1);

namespace Leaditin\Annotations;

use Leaditin\Annotations\Exception\CollectionException;

/**
 * Class Collection
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class Collection implements \IteratorAggregate, \Countable
{
    /** @var array|Annotation[] */
    protected $annotations;

    /**
     * @param Annotation[] ...$annotations
     */
    public function __construct(Annotation ...$annotations)
    {
        $this->annotations = $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->annotations);
    }

    /**
     * {@inheritdoc}
     */
    public function count() : int
    {
        return count($this->annotations);
    }

    /**
     * @return Annotation[]
     */
    public function getAll() : array
    {
        return $this->annotations;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name) : bool
    {
        foreach ($this->annotations as $annotation) {
            if ($annotation->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     * @return Annotation
     * @throws CollectionException
     */
    public function findOne(string $name) : Annotation
    {
        foreach ($this->annotations as $annotation) {
            if ($annotation->getName() === $name) {
                return $annotation;
            }
        }

        throw CollectionException::undefinedAnnotation($name);
    }

    /**
     * @param string $name
     * @return Collection|Annotation[]
     */
    public function find(string $name) : Collection
    {
        $matched = [];

        foreach ($this->annotations as $annotation) {
            if ($annotation->getName() === $name) {
                $matched[] = $annotation;
            }
        }

        return new static(...$matched);
    }
}

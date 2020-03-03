<?php

namespace Manzadey\PropertyContainer;

/**
 * Class PropertyContainer
 *
 * @package Manzadey\PropertyContainer
 */
class PropertyContainer
{
    /**
     * @var array
     */
    private $properties = [];

    /**
     * @var string
     */
    private $tag;

    /**
     * @param $key
     * @param $property
     *
     * @return bool
     */
    public function push($key, $property) : bool
    {
        if (!empty($this->tag)) {
            $this->properties[$this->tag][$key] = $property;
            $result                             = !empty($this->properties[$this->tag][$key]);
            $this->tag                          = null;
        } else {
            $this->properties[$key] = $property;
            $result                 = !empty($this->properties[$key]);
        }

        return $result;


    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if (!empty($this->tag)) {
            $this->propertyExistsWithTag($this->tag, $key);

            return $this->properties[$this->tag][$key];
        }

        $this->propertyExists($key);

        return $this->properties[$key];
    }

    /**
     * @return array
     */
    public function all() : array
    {
        return $this->properties;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function delete($key) : bool
    {
        $this->propertyExists($key);

        unset($this->properties[$key]);

        return empty($this->properties[$key]);
    }

    /**
     * @return bool
     */
    public function flush() : bool
    {
        unset($this->properties);

        return empty($this->properties);
    }

    /**
     * @param string $tag
     *
     * @return $this
     */
    public function tag(string $tag) : self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @param $key
     */
    private function propertyExists($key) : void
    {
        if (!isset($this->properties[$key])) {
            throw new \RuntimeException('The property "' . $key . '" does not exists!');
        }
    }

    /**
     * @param $tag
     * @param $key
     */
    private function propertyExistsWithTag($tag, $key) : void
    {
        if (!isset($this->properties[$tag][$key])) {
            throw new \RuntimeException('The tag "' . $tag . '" with property "' . $key . '" does not exists!');
        }
    }
}
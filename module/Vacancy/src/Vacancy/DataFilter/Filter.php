<?php

namespace Vacancy\DataFilter;

/**
 * Data filter class. Implements Mediator pattern and consist of two main parts: Hydration and Backend
 * Hydration performed through method Filter::hydrate which accept a HydratorInterface object. Given object populates
 * values of this filter
 * Backends are the filters (collection filters, queryBuilder filters, ...) and they must implement BackendInterface,
 * when Filter::filter() is called, all the Backends called consistently (FIFO principle) and work with specified data
 *
 * @package Vacancy\DataFilter
 */
class Filter
{

    /**
     * @var array
     */
    protected $values = array();

    /**
     * @var array
     */
    protected $backends = array();

    /**
     * @param array $values
     *
     * @return $this
     */
    public function setValues(array $values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Sets value to filter stack of values
     *
     * @param int|string $name
     * @param mixed      $value
     *
     * @return $this
     */
    public function setValue($name, $value)
    {
        $this->values[$name] = $value;
        return $this;
    }

    /**
     * Returns value with name (key) $name
     *
     * @param string|int $name
     *
     * @return mixed|null
     */
    public function getValue($name)
    {
        return (isset($this->values[$name])) ? $this->values[$name] : null;
    }

    /**
     * Removes value with name (key) $name if exist
     *
     * @param string|int $name
     *
     * @return $this
     */
    public function removeValue($name)
    {
        if (isset($this->values[$name])) {
            unset($this->values[$name]);
        }

        return $this;
    }

    /**
     * Given HydratorInterface object hydrates values to Filter (e.g. from array to Filter values)
     *
     * @param HydratorInterface $hydrator
     *
     * @return $this
     */
    public function hydrate(HydratorInterface $hydrator)
    {
        $hydrator->hydrate($this);
        return $this;
    }

    /**
     * Adds given BackendInterface object to filter stack of backends. If $alias given, then you can retrieve this object
     * later by this alias. If $alias is not set, class name if given object will be used
     *
     * @param BackendInterface $backend
     * @param int|string|null  $alias
     *
     * @return $this
     */
    public function addBackend(BackendInterface $backend, $alias = null)
    {
        $alias = (isset($alias)) ? $alias : get_class($backend);
        $this->backends[$alias] = $backend;
        return $this;
    }

    /**
     * Returns BackendInterface object by alias from Filter stack of backends
     *
     * @param int|string $alias
     *
     * @return null
     */
    public function getBackend($alias)
    {
        return isset($this->backends[$alias]) ? $this->backends[$alias] : null;
    }

    /**
     * Removes BackendInterface with given alias from Filter stack of backends
     *
     * @param int|string $alias
     *
     * @return $this
     */
    public function removeBackend($alias)
    {
        if (isset($this->backends[$alias])) {
            unset($this->backends[$alias]);
        }
        return $this;
    }

    /**
     * Returns array of BackendInterface objects
     *
     * @return array
     */
    public function getBackends()
    {
        return $this->backends;
    }

    /**
     * Iterates through the array of existing BackendInterface objects of this Filter and calls BackendInterface::filter()
     * method
     */
    public function filter()
    {
        /** @var BackendInterface $backend */
        foreach ($this->backends as $backend) {
            $backend->filter($this);
        }
    }

} 
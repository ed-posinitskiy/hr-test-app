<?php

namespace Vacancy\DataFilter;

class Filter {

    protected $values = array();

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
     * @param int|string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($name, $value)
    {
        $this->values[$name] = $value;
        return $this;
    }

    /**
     * @param string|int $name
     *
     * @return mixed|null
     */
    public function getValue($name)
    {
        return (isset($this->values[$name])) ? $this->values[$name] : null;
    }

    /**
     * @param string|int $name
     *
     * @return $this
     */
    public function removeValue($name)
    {
        if(isset($this->values[$name])) {
            unset($this->values[$name]);
        }

        return $this;
    }

    /**
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
     * @param BackendInterface $backend
     * @param int|string|null             $alias
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
     * @param int|string $alias
     *
     * @return null
     */
    public function getBackend($alias)
    {
        return isset($this->backends[$alias]) ? $this->backends[$alias] : null;
    }

    /**
     * @param int|string $alias
     *
     * @return $this
     */
    public function removeBackend($alias)
    {
        if(isset($this->backends[$alias])) {
            unset($this->backends[$alias]);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getBackends()
    {
        return $this->backends;
    }

    public function filter()
    {
        /** @var BackendInterface $backend */
        foreach($this->backends as $backend) {
            $backend->filter($this);
        }
    }

} 
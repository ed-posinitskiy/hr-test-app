<?php

namespace Vacancy\DataFilter\Hydrator;

use Vacancy\DataFilter\Filter;
use Vacancy\DataFilter\HydratorInterface;

class ArrayHydrator implements HydratorInterface {

    protected $array = array();

    public function __construct(array $array = null)
    {
        if(isset($array)) {
            $this->setArray($array);
        }
    }

    /**
     * @param array $array
     *
     * @return $this
     */
    public function setArray(array $array)
    {
        $this->array = $array;
        return $this;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }

    public function hydrate(Filter $filter)
    {
        foreach($this->array as $key => $value) {
            $filter->setValue($key, $value);
        }
    }


} 
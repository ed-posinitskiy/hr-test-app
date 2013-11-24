<?php

namespace Department\InputFilter;

use Zend\InputFilter\InputFilter;

class DepartmentEdit extends InputFilter
{

    public function __construct()
    {
        $this->add(
            $this->getFactory()->createInput(
                array(
                     'name'     => 'name',
                     'required' => true,
                     'filters'  => array(
                         array('name' => 'StringTrim'),
                         array('name' => 'StripTags')
                     )
                )
            )
        );
    }

} 
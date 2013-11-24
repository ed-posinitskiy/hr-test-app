<?php

namespace Translation\InputFilter;

use Zend\InputFilter\InputFilter;

class LanguageEdit extends InputFilter
{

    public function __construct()
    {
        $this->add(
            $this->getFactory()->createInput(
                array(
                     'name'     => 'title',
                     'required' => true,
                     'filters'  => array(
                         array('name' => 'StringTrim'),
                         array('name' => 'StripTags')
                     )
                )
            )
        );

        $this->add(
            $this->getFactory()->createInput(
                array(
                     'name'       => 'locale',
                     'required'   => true,
                     'filters'  => array(
                         array('name' => 'StringTrim'),
                         array('name' => 'StripTags')
                     ),
                     'validators' => array(
                         array(
                             'name'    => 'StringLength',
                             'options' => array(
                                 'min' => 2,
                                 'max' => 10
                             )
                         )
                     )
                )
            )
        );
    }

} 
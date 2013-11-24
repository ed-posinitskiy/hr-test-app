<?php

namespace Translation\InputFilter;

use Zend\InputFilter\InputFilter;

class TranslationEdit extends InputFilter
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
                     'name'     => 'description',
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
                     'name'     => 'language',
                     'required' => true,
                     'validators' => array(
                         array(
                             'name' => 'NotEmpty',
                             'options' => array(
                                 'type' => \Zend\Validator\NotEmpty::ALL
                             )
                         )
                     )
                )
            )
        );
    }

} 
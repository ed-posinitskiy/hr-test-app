<?php

namespace Department\Form;

use Zend\Form\Form as ZendForm;

class DepartmentEdit extends ZendForm
{

    public function __construct($options = array(), $name = 'department_edit')
    {
        parent::__construct($name, $options);
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                 'name'    => 'name',
                 'type'    => 'Text',
                 'options' => array(
                     'label' => 'Name'
                 ),
            )
        );

        $this->add(
            array(
                 'name'       => 'submit',
                 'type'       => 'Submit',
                 'attributes' => array(
                     'value' => 'Save',
                     'id'    => 'submit-button'
                 )
            )
        );
    }
} 
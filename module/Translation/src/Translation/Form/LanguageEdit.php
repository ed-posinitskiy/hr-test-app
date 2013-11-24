<?php

namespace Translation\Form;

use Zend\Form\Form as ZendForm;

class LanguageEdit extends ZendForm
{

    public function __construct($options = array(), $name = 'language_edit')
    {
        parent::__construct($name, $options);
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                 'name'    => 'title',
                 'type'    => 'Text',
                 'options' => array(
                     'label' => 'Title'
                 ),
            )
        );

        $this->add(
            array(
                 'name'       => 'locale',
                 'type'       => 'Text',
                 'options'    => array(
                     'label' => 'Locale',
                     'help-block' => 'from 2 to 10 characters'
                 ),
                 'attributes' => array(
                     'maxlen' => 10
                 )
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
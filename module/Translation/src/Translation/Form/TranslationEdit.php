<?php

namespace Translation\Form;

use Zend\Form\Form as ZendForm;

class TranslationEdit extends ZendForm {

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
                 'name'    => 'language',
                 'type'    => 'Select',
                 'options' => array(
                     'label'         => 'Language',
                     'value_options' => array(
                         0 => 'Select a language'
                     )
                 ),
            )
        );

        $this->add(
            array(
                 'name'       => 'description',
                 'type'       => 'Textarea',
                 'options'    => array(
                     'label' => 'Description'
                 ),
                 'attributes' => array(
                     'rows' => 12
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

    /**
     * Populates options of "language" element which is HTML Select with given array|\Traversable of
     * \Translation\Entity\Language objects
     *
     * @param array|\Traversable $languages
     * @param bool               $flush
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function populateLanguages($languages, $flush = false)
    {
        if (!is_array($languages) && !$languages instanceof \Traversable) {
            throw new \InvalidArgumentException('Given value must be an array or instance of \Traversable');
        }

        if (true === $flush) {
            $valueOptions = array(0 => 'Select a language');
        } else {
            $valueOptions = $this->get('language')->getValueOptions();
        }

        $newOptions = array();

        /** @var \Translation\Entity\Language $language*/
        foreach ($languages as $language) {
            $newOptions[$language->getId()] = $language->getTitle();
        }

        $this->get('language')->setValueOptions($valueOptions + $newOptions);

        return $this;
    }

} 
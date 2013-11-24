<?php

namespace Vacancy\Form;

use Zend\Form\Form as ZendForm;

class VacancyEdit extends ZendForm
{

    public function __construct($options = array(), $name = 'vacancy_edit')
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
                 'name'    => 'department',
                 'type'    => 'Select',
                 'options' => array(
                     'label'         => 'Department',
                     'value_options' => array(
                         0 => 'Select a department'
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
     * Populates options of "department" element which is HTML Select with given array|\Traversable of
     * \Department\Entity\Department objects
     *
     * @param array|\Traversable $departments
     * @param bool               $flush
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function populateDepartments($departments, $flush = false)
    {
        if (!is_array($departments) && !$departments instanceof \Traversable) {
            throw new \InvalidArgumentException('Given value must be an array or instance of \Traversable');
        }

        if (true === $flush) {
            $valueOptions = array(0 => 'Select a department');
        } else {
            $valueOptions = $this->get('department')->getValueOptions();
        }

        $newOptions = array();
        /** @var \Department\Entity\Department $department */
        foreach ($departments as $department) {
            $newOptions[$department->getId()] = $department->getName();
        }

        $this->get('department')->setValueOptions($valueOptions + $newOptions);

        return $this;
    }

} 
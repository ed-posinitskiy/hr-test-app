<?php

namespace Vacancy\Form;

use Zend\Form\Form as ZendForm;

class VacancyFilter extends ZendForm
{

    public function __construct($options = array(), $name = 'vacancy_filter')
    {
        parent::__construct($name, $options);
        $this->setAttribute('method', 'get');

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
                 'name'    => 'language',
                 'type'    => 'Select',
                 'options' => array(
                     'label'         => 'Language',
                     'value_options' => array(
                         0 => 'Base language (en)'
                     )
                 ),
            )
        );

        $this->add(
            array(
                 'name' => 'submit',
                 'type' => 'Submit',
                 'attributes' => array(
                     'value' => 'Search'
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
            $valueOptions = array(0 => 'Base language (en)');
        } else {
            $valueOptions = $this->get('language')->getValueOptions();
        }

        $newOptions = array();
        /** @var \Translation\Entity\Language $language*/
        foreach($languages as $language) {
            $newOptions[$language->getLocale()] = $language->getTitle();
        }

        $this->get('language')->setValueOptions($valueOptions + $newOptions);

        return $this;
    }
} 
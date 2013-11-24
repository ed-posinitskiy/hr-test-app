<?php

namespace Vacancy\Controller;

use Translation\Entity\Translation;
use Vacancy\DataFilter\Backend\DepartmentFllterBackend;
use Vacancy\DataFilter\Backend\DoctrinePaginationBackend;
use Vacancy\DataFilter\Backend\LanguageFilterBackend;
use Vacancy\DataFilter\Backend\VacancyFilterBackend;
use Vacancy\DataFilter\Filter;
use Vacancy\DataFilter\Hydrator\ArrayHydrator;
use Vacancy\Entity\Vacancy;
use Vacancy\Form\VacancyEdit;
use Vacancy\Form\VacancyFilter;
use Vacancy\Hydrator\Strategy\DepartmentValueStrategy;
use Vacancy\InputFilter\VacancyEdit as VacancyEditInputFilter;
use Zend\Mvc\Controller\AbstractActionController;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ClassMethods;

class IndexController extends AbstractActionController
{

    /**
     * Doctrine EntityManager
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * Sets Doctrine\ORM\EntityManager instance
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Returns Doctrine\ORM\EntityManager instance. If instance is not set, then sets one from ServeiceLocator
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        if (!isset($this->em)) {
            $this->setEm($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        return $this->em;
    }

    /**
     * List of all vacancies with pagination and filters (department, language)
     */
    public function indexAction()
    {
        $config = $this->getServiceLocator()->get('Config');
        $config = isset($config['vacancy_module']) ? $config['vacancy_module'] : array();

        $filterForm = new VacancyFilter();
        $filterForm->setConfig($config);

        $departments = $this->getEm()->getRepository('Department\Entity\Department')->findAll();
        $languages = $this->getEm()->getRepository('Translation\Entity\Language')->findAll();

        $filterForm->populateDepartments((is_array($departments)) ? $departments : array());
        $filterForm->populateLanguages((is_array($languages)) ? $languages : array());

        $formData = $this->params()->fromQuery();
        $filterForm->setData($formData);

        $filter = new Filter();
        $filter->hydrate(new ArrayHydrator($formData));

        $departmentBackend = new DepartmentFllterBackend('department', 'd.id');
        $filter->addBackend($departmentBackend);


        $languageBackend = new LanguageFilterBackend('language', 'l.locale');
        $languageBackend->setConfig($config);
        $filter->addBackend($languageBackend);

        $paginationBackend = new DoctrinePaginationBackend($this->params()->fromRoute('page', 1), 5);
        $filter->addBackend($paginationBackend);

        $repository = $this->getEm()->getRepository('Vacancy\Entity\Vacancy');
        $paginator = $repository->findByFilterNested($filter);

        return array(
            'filterForm' => $filterForm,
            'paginator' => $paginator,
            'locale' => $filter->getValue('language')
        );
    }

    /**
     * Add a new vacancy
     */
    public function addAction()
    {
        $departments = $this->getEm()->getRepository('Department\Entity\Department')->findAll();
        $form = new VacancyEdit();
        $form->populateDepartments(is_array($departments) ? $departments : array());

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            $form->setInputFilter(new VacancyEditInputFilter());
            if ($form->isValid()) {
                $vacancy = new Vacancy();
                $hydrator = new ClassMethods();
                $hydrator->addStrategy('department', new DepartmentValueStrategy($this->getEm()));
                $form->setHydrator($hydrator);
                $form->setObject($vacancy)->bindValues();

                $langRepository = $this->getEm()->getRepository('Translation\Entity\Language');
                $config = $this->getServiceLocator()->get('Config');
                $langRepository->setConfig(isset($config['vacancy_module']) ? $config['vacancy_module'] : array());
                $language = $langRepository->findBaseLanguage();
                $translation = new Translation();
                $form->setObject($translation)->bindValues();
                $translation->setVacancy($vacancy);
                $translation->setLanguage($language);

                $this->getEm()->persist($vacancy);
                $this->getEm()->persist($translation);
                $this->getEm()->flush();

                return $this->redirect()->toRoute('vacancy/list');
            }
        }

        return array(
            'form' => $form
        );
    }

    /**
     * Edit existing vacancy
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        /** @var \Vacancy\Entity\Vacancy $vacancy */
        $vacancy = $this->getEm()->find('Vacancy\Entity\Vacancy', $id);
        if (!$vacancy) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        $departments = $this->getEm()->getRepository('Department\Entity\Department')->findAll();
        $form = new VacancyEdit();
        $form->populateDepartments(is_array($departments) ? $departments : array());
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('department', new DepartmentValueStrategy($this->getEm()));
        $form->setHydrator($hydrator);
        $form->bind($vacancy);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            $form->setInputFilter(new VacancyEditInputFilter());
            if ($form->isValid()) {
                $this->getEm()->persist($vacancy);
                $this->getEm()->flush();

                return $this->redirect()->toRoute('vacancy/list');
            }
        }

        return array(
            'vacancy' => $vacancy,
            'form'    => $form
        );
    }

    /**
     * Delete vacancy and all related translations
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        /** @var \Vacancy\Entity\Vacancy $vacancy */
        $vacancy = $this->getEm()->find('Vacancy\Entity\Vacancy', $id);
        if (!$vacancy) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        if($this->getRequest()->isPost()) {
            $decision = $this->params()->fromPost('delete', 'No');

            if($decision == 'Yes') {
                $this->getEm()->remove($vacancy);
                $this->getEm()->flush();
            }

            return $this->redirect()->toRoute('vacancy/list');
        }

        return array(
            'vacancy' => $vacancy
        );
    }

    /**
     * Detailed vacancy view with list of translations
     */
    public function itemAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        /** @var \Vacancy\Entity\Vacancy $vacancy */
        $vacancy = $this->getEm()->find('Vacancy\Entity\Vacancy', $id);
        if (!$vacancy) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        return array(
            'vacancy' => $vacancy
        );
    }

}

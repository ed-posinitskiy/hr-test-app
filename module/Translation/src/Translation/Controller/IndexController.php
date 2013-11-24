<?php

namespace Translation\Controller;

use Translation\Entity\Translation;
use Translation\Form\TranslationEdit;
use Translation\Hydrator\Strategy\LanguageValueStrategy;
use Translation\InputFilter\TranslationEdit as TranslationEditInputFilter;
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

    public function indexAction()
    {
        return array();
    }

    public function addAction()
    {
        $vacancy_id = $this->params()->fromRoute('vacancy_id', 0);
        if (!$vacancy_id) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        /** @var \Vacancy\Entity\Vacancy $vacancy */
        $vacancy = $this->getEm()->find('Vacancy\Entity\Vacancy', $vacancy_id);
        if (!$vacancy) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        $repository = $this->getEm()->getRepository('Translation\Entity\Language');
        $languages = $repository->findAvailableLanguages($vacancy);
        $form = new TranslationEdit();
        $form->populateLanguages((is_array($languages)) ? $languages : array());

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            $form->setInputFilter(new TranslationEditInputFilter());
            if ($form->isValid()) {
                $translation = new Translation();
                $translation->setVacancy($vacancy);
                $hydrator = new ClassMethods();
                $hydrator->addStrategy('language', new LanguageValueStrategy($this->getEm()));
                $form->setHydrator($hydrator);
                $form->setObject($translation)->bindValues();

                $this->getEm()->persist($translation);
                $this->getEm()->flush();

                return $this->redirect()->toRoute('vacancy/item', array('id' => $vacancy->getId()));
            }
        }

        return array(
            'vacancy' => $vacancy,
            'form'    => $form
        );
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect('vacancy/list');
        }

        /** @var \Translation\Entity\Translation $translation */
        $translation = $this->getEm()->find('Translation\Entity\Translation', $id);
        if (!$translation) {
            return $this->redirect('vacancy/list');
        }

        $repository = $this->getEm()->getRepository('Translation\Entity\Language');
        $languages = $repository->findAvailableLanguages($translation->getVacancy(), $translation);
        $form = new TranslationEdit();
        $form->populateLanguages((is_array($languages)) ? $languages : array());
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('language', new LanguageValueStrategy($this->getEm()));
        $form->setHydrator($hydrator);
        $form->bind($translation);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            $form->setInputFilter(new TranslationEditInputFilter());
            if ($form->isValid()) {
                $this->getEm()->persist($translation);
                $this->getEm()->flush();

                $this->redirect()->toRoute('vacancy/item', array('id' => $translation->getVacancy()->getId()));
            }
        }

        return array(
            'translation' => $translation,
            'form'        => $form
        );
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if(!$id) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        $translation = $this->getEm()->find('Translation\Entity\Translation', $id);

        if(!$translation) {
            return $this->redirect()->toRoute('vacancy/list');
        }

        if($this->getRequest()->isPost()) {
            $decision = $this->params()->fromPost('delete', 'No');

            if($decision == 'Yes') {
                $this->getEm()->remove($translation);
                $this->getEm()->flush();
            }

            return $this->redirect()->toRoute('vacancy/list');
        }

        return array(
            'translation' => $translation
        );
    }

}

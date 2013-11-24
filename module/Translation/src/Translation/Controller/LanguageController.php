<?php

namespace Translation\Controller;

use Translation\Entity\Language;
use Translation\Form\LanguageEdit;
use Translation\InputFilter\LanguageEdit as LanguageEditInputFilter;
use Zend\Mvc\Controller\AbstractActionController;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ClassMethods;

class LanguageController extends AbstractActionController
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
        if(!isset($this->em)) {
            $this->setEm($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        return $this->em;
    }

    /**
     * List of all languages
     */
    public function indexAction()
    {
        $languages = $this->getEm()->getRepository('Translation\Entity\Language')->findAll();

        return array(
            'languages' => $languages
        );
    }

    /**
     * Add a new language
     */
    public function addAction()
    {
        $form = new LanguageEdit();

        if($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            $form->setInputFilter(new LanguageEditInputFilter());
            if($form->isValid()) {
                $language = new Language();
                $form->setHydrator(new ClassMethods());
                $form->setObject($language)->bindValues();

                $this->getEm()->persist($language);
                $this->getEm()->flush();

                return $this->redirect()->toRoute('language/list');
            }
        }

        return array(
            'form' => $form
        );
    }

    /**
     * Edit existing language
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if(!$id) {
            return $this->redirect()->toRoute('language/list');
        }

        /** @var \Translation\Entity\Language $language */
        $language = $this->getEm()->find('Translation\Entity\Language', $id);

        if(!$language) {
            return $this->redirect()->toRoute('language/list');
        }

        $form = new LanguageEdit();
        $form->setHydrator(new ClassMethods());
        $form->bind($language);

        if($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            $form->setInputFilter(new LanguageEditInputFilter());
            if($form->isValid()) {
                $this->getEm()->persist($language);
                $this->getEm()->flush();

                $this->redirect()->toRoute('language/list');
            }
        }

        return array(
            'form' => $form,
            'language' => $language
        );
    }

    /**
     * Delete Language
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if(!$id) {
            return $this->redirect()->toRoute('language/list');
        }

        /** @var \Translation\Entity\Language $language */
        $language = $this->getEm()->find('Translation\Entity\Language', $id);

        if(!$language) {
            return $this->redirect()->toRoute('language/list');
        }

        if($this->getRequest()->isPost()) {
            $decision = $this->params()->fromPost('delete', 'No');

            if($decision == 'Yes') {
                $this->getEm()->remove($language);
                $this->getEm()->flush();
            }

            return $this->redirect()->toRoute('language/list');
        }

        return array(
            'language' => $language
        );
    }

}

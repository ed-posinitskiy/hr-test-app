<?php

namespace Department\Controller;

use Department\Entity\Department;
use Department\Form\DepartmentEdit;
use Department\InputFilter\DepartmentEdit as DepartmentEditInputFilter;
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
        if(!isset($this->em)) {
            $this->setEm($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        return $this->em;
    }

    public function indexAction()
    {
        $departments = $this->getEm()->getRepository('Department\Entity\Department')->findAll();

        return array(
            'departments' => $departments
        );
    }

    public function addAction()
    {
        $form = new DepartmentEdit();

        if($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            $form->setInputFilter(new DepartmentEditInputFilter());
            if($form->isValid()) {
                $department = new Department();
                $form->setHydrator(new ClassMethods());
                $form->setObject($department)->bindValues();

                $this->getEm()->persist($department);
                $this->getEm()->flush();

                return $this->redirect()->toRoute('department/list');
            }
        }

        return array(
            'form' => $form
        );
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if(!$id) {
            return $this->redirect()->toRoute('department/list');
        }

        /** @var \Department\Entity\Department $department */
        $department = $this->getEm()->find('Department\Entity\Department', $id);

        if(!$department) {
            return $this->redirect()->toRoute('department/list');
        }

        $form = new DepartmentEdit();
        $form->setHydrator(new ClassMethods());
        $form->bind($department);

        if($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            $form->setInputFilter(new DepartmentEditInputFilter());
            if($form->isValid()) {
                $this->getEm()->persist($department);
                $this->getEm()->flush();

                $this->redirect()->toRoute('department/list');
            }
        }

        return array(
            'form' => $form,
            'department' => $department
        );
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if(!$id) {
            return $this->redirect()->toRoute('department/list');
        }

        /** @var \Department\Entity\Department */
        $department = $this->getEm()->find('Department\Entity\Department', $id);

        if(!$department) {
            return $this->redirect()->toRoute('department/list');
        }

        if($this->getRequest()->isPost()) {
            $decision = $this->params()->fromPost('delete', 'No');

            if($decision == 'Yes') {
                $this->getEm()->remove($department);
                $this->getEm()->flush();
            }

            return $this->redirect()->toRoute('department/list');
        }

        return array(
            'department' => $department
        );
    }

}

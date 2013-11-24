<?php

namespace Department\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Vacancy\Entity\Vacancy;

/**
 * Class Department
 *
 * @ORM\Entity
 * @ORM\Table(name="departments")
 */
class Department
{
    /**
     * Primary key (i.e. Identifier). Auto increment value
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * Department name
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $name;

    /**
     * Collection of Vacancy\Entity\Vacancy instances for this department (i.e. vacancies of this department)
     *
     * @ORM\OneToMany(targetEntity="Vacancy\Entity\Vacancy", mappedBy="department", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @var ArrayCollection
     */
    protected $vacancies;

    public function __construct()
    {
        $this->vacancies = new ArrayCollection();
    }

    /**
     * Returns identifier value
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets department name. Implements fluent interface
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns department name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets collection of vacancies for this department
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $vacancies
     *
     * @return $this
     */
    public function setVacancies(ArrayCollection $vacancies)
    {
        $this->vacancies = $vacancies;
        return $this;
    }

    /**
     * Returns collection of vacancies for this department
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getVacancies()
    {
        return $this->vacancies;
    }

    /**
     * Adds given \Vacancy\Entity\Vacancy instance to collection.
     * Also set this department as a related for given vacancy
     * Implements fluent interface
     *
     * @param \Vacancy\Entity\Vacancy $vacancy
     *
     * @return $this
     */
    public function addVacancy(Vacancy $vacancy)
    {
        $this->vacancies->add($vacancy);
        $vacancy->setDepartment($this);
        return $this;
    }

    /**
     * Removes given \Vacancy\Entity\Vacancy instance from collection
     * Implements fluent interface
     *
     * @param \Vacancy\Entity\Vacancy $vacancy
     *
     * @return $this
     */
    public function removeVacancy(Vacancy $vacancy)
    {
        $this->vacancies->removeElement($vacancy);
        return $this;
    }

} 
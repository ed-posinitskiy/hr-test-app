<?php

namespace Vacancy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Department\Entity\Department;
use Translation\Entity\Translation;

/**
 * Vacancy Entity
 *
 * @ORM\Entity(repositoryClass="Vacancy\Repository\Vacam")
 * @ORM\Table(name="vacancy")
 *
 * @package Vacancy\Entity
 */
class Vacancy
{

    /**
     * Primary key (i.e. identifier) of the vacancy. Auto incremented value
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * Title of the vacancy
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $title;

    /**
     * Descrption of the vacancy
     *
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $description;

    /**
     * Instance of \Department\Entity\Department of related department
     *
     * @ORM\ManyToOne(targetEntity="Department\Entity\Department", inversedBy="vacancies")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @var Department
     */
    protected $department;

    /**
     * Collection of Translation\Entity\Translation instances for this vacancy (i.e. translations)
     *
     * @ORM\OneToMany(targetEntity="Translation\Entity\Translation", mappedBy="vacancy",
     * cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @var ArrayCollection
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * Sets \Department\Entity\Department instance for this vacancy. Implements fluent interface
     *
     * @param \Department\Entity\Department $department
     *
     * @return $this
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * Returns \Department\Entity\Department instance for this vacancy
     *
     * @return \Department\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Sets description value of the vacancy. Implements fluent interface
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Returns description value of the vacancy
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns id value of the vacancy
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets title value of the vacancy. Implements fluent interface
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns title value of the vacancy
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets collection of Translation\Entity\Translation instances for this vacancy (i.e. vacancy translations)
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $translations
     *
     * @return $this
     */
    public function setTranslations(ArrayCollection $translations)
    {
        $this->translations = $translations;
        return $this;
    }

    /**
     * Returns collection of Translation\Entity\Translation instances for this vacancy
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }


    /**
     * Adds given \Translation\Entity\Translation instance to collection.
     * Also set this vacancy as a related for given translation
     * Implements fluent interface
     *
     * @param \Translation\Entity\Translation $translation
     *
     * @return $this
     */
    public function addTranslation(Translation $translation)
    {
        $this->translations->add($translation);
        $translation->setVacancy($this);
        return $this;
    }

    /**
     * Removes given \Translation\Entity\Translation instance from collection
     * Implements fluent interface
     *
     * @param \Translation\Entity\Translation $translation
     *
     * @return $this
     */
    public function removeTranslation(Translation $translation)
    {
        $this->translations->removeElement($translation);
        return $this;
    }

} 
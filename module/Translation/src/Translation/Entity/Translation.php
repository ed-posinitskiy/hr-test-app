<?php

namespace Translation\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vacancy\Entity\Vacancy;

/**
 * Translation Entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="translations")
 *
 * @package Translation\Entity
 */
class Translation {

    /**
     * Primary key (i.e. identifier) of the language. Auto incremented value
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * Translated title of related vacancy
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $title;
    /**
     * Translated description of related vacancy
     *
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $description;

    /**
     * Instance of \Translation\Entity\Language to hold related language of this translation. Part of a complex primary key
     *
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @var Language
     */
    protected $language;

    /**
     * Instance of \Vacancy\Entity\Vacancy to hold related vacancy. Part of a complex primary key
     *
     * @ORM\ManyToOne(targetEntity="Vacancy\Entity\Vacancy", inversedBy="translations")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @var Vacancy
     */
    protected $vacancy;

    /**
     * Returns id value
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets translated description of related vacancy
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
     * Returns translated description of related vacancy
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets \Translation\Entity\Language instance of related language
     *
     * @param \Translation\Entity\Language $language
     *
     * @return $this
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Returns \Translation\Entity\Language instance of related language
     *
     * @return \Translation\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets translated title of related vacancy
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
     * Returns translated title of related vacancy
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets \Vacancy\Entity\Vacancy instance of related vacancy
     *
     * @param \Vacancy\Entity\Vacancy $vacancy
     *
     * @return $this
     */
    public function setVacancy(Vacancy $vacancy)
    {
        $this->vacancy = $vacancy;
        return $this;
    }

    /**
     * Returns \Vacancy\Entity\Vacancy instance of related vacancy
     *
     * @return \Vacancy\Entity\Vacancy
     */
    public function getVacancy()
    {
        return $this->vacancy;
    }

} 
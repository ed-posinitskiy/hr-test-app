<?php

namespace Translation\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language Entity
 *
 * @ORM\Entity(repositoryClass="Translation\Repository\LanguageRepository")
 * @ORM\Table(name="languages")
 */
class Language {

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
     * Language locale (e.g. en, ru, fr ...). Primary key and Identifier
     *
     * @ORM\Column(type="string", length=10)
     *
     * @var string
     */
    protected $locale;

    /**
     * Language title (e.g. english, russian, french ...)
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $title;

    /**
     * Return id value of the language
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets locale value. Implements fluent interface
     *
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Returns lacale value
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Sets title value. Implements fluent interface
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
     * Returns title value
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

} 
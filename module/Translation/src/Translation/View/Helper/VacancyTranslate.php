<?php

namespace Translation\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Vacancy\Entity\Vacancy;
use Translation\Entity\Translation;

class VacancyTranslate extends AbstractHelper
{

    const DEFAULT_LOCALE = 'en';

    /**
     * @var Vacancy
     */
    protected $vacancy;

    /**
     * @var Translation
     */
    protected $matchedTranslation;

    public function __invoke($locale = null)
    {
        if(isset($locale)) {
            $this->matchedTranslation = $this->_findTranslation($locale);
        }
        return $this;
    }

    public function __toString()
    {
        return '';
    }

    /**
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
     * @return \Vacancy\Entity\Vacancy
     */
    public function getVacancy()
    {
        return $this->vacancy;
    }

    /**
     * @return \Translation\Entity\Translation
     */
    public function getMatchedTranslation()
    {
        return $this->matchedTranslation;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        if(!isset($this->matchedTranslation)) {
            return static::DEFAULT_LOCALE;
        }

        return $this->matchedTranslation->getLanguage()->getLocale();
    }

    public function getTitle()
    {
        if(!isset($this->matchedTranslation)) {
            return $this->getVacancy()->getTitle();
        }

        return $this->matchedTranslation->getTitle();
    }

    public function getDescription() {
        if(!isset($this->matchedTranslation)) {
            return $this->getVacancy()->getDescription();
        }

        return $this->matchedTranslation->getTitle();
    }

    protected function _findTranslation($locale)
    {
        if(!isset($this->vacancy)) {
            return null;
        }

        $translations = $this->getVacancy()->getTranslations();
        foreach($translations as $translation) {
            if($translation->getLanguage()->getLocale() == $locale) {
                return $translation;
            }
        }

        return null;
    }

} 
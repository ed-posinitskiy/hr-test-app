<?php

namespace Translation\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Vacancy\Entity\Vacancy;
use Translation\Entity\Translation;

/**
 * View Helper to manage translations of the given Vacancy. Returns translated title end description with given locale.
 * If locale is not set, uses default locale (en)
 *
 * @package Translation\View\Helper
 */
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
        $this->matchedTranslation = $this->_findTranslation(isset($locale) ? $locale : self::DEFAULT_LOCALE);
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
     * Returns current locale
     *
     * @return string
     */
    public function getLocale()
    {
        if (!isset($this->matchedTranslation)) {
            return static::DEFAULT_LOCALE;
        }

        return $this->matchedTranslation->getLanguage()->getLocale();
    }

    /**
     * Returns translated title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->matchedTranslation->getTitle();
    }

    /**
     * Returns translated description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->matchedTranslation->getTitle();
    }

    /**
     * Tries to find translation by given locale. Performed every time when __invoke() method been called
     *
     * @param $locale
     *
     * @return null
     */
    protected function _findTranslation($locale)
    {
        if (!isset($this->vacancy)) {
            return null;
        }

        $translations = $this->getVacancy()->getTranslations();
        foreach ($translations as $translation) {
            if ($translation->getLanguage()->getLocale() == $locale) {
                return $translation;
            }
        }

        return null;
    }

} 
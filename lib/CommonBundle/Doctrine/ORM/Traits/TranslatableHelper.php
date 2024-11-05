<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use Common\Symfony\Utils\Common;
use Doctrine\Common\Collections\Collection;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait TranslatableHelper
{
    /**
     * Returns enabled translations.
     *
     * @return Collection
     */
    public function getEnabledTranslations()
    {
        return $this->getTranslations()->filter(static fn ($translation) => $translation->isEnabled());
    }

    /** Returns an array of locales from enabled translations. */
    public function getEnabledLocaleAsArray(): array
    {
        $locales = [];

        foreach ($this->getEnabledTranslations() as $translation) {
            $locales[] = $translation->getLocale();
        }

        return $locales;
    }

    /** Returns a string of comma-separated locales from enabled translations. */
    public function getEnabledLocaleAsString(): string
    {
        return implode(', ', $this->getEnabledLocaleAsArray());
    }

    /**
     * Soon to be deprecated
     * Returns an array of enabled locales and their corresponding country flag codes.
     */
    public function getEnabledLocaleAndCountry(): array
    {
        $geoLocale = [];

        foreach ($this->getEnabledLocaleAsArray() as $locale) {
            $geoLocale[] = [
                'locale' => $locale,
                'country' => Common::getLanguageFlagCode($locale),
            ];
        }

        return $geoLocale;
    }
}

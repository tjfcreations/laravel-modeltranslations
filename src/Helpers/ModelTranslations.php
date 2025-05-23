<?php

namespace Tjall\ModelTranslations\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Collection;

class ModelTranslations {
    public static function isMultiLocale() {
        return Config::has('locale.locales');
    }

    public static function getCurrentLocaleMessage(Collection $messages) {
        $texts = array_column($messages->toArray(), 'text', 'locale');

        // check for message in current locale
        $current_locale = App::currentLocale();
        if (isset($texts[$current_locale])) return $texts[$current_locale];

        // check for message in locale-specific fallback locales
        $fallback_locales = (array) __('config.fallback_locales');
        foreach ($fallback_locales as $locale) {
            if (isset($texts[$locale])) return $texts[$locale];
        }

        // check for general application fallback locale
        $fallback_locale = App::getFallbackLocale();
        if (isset($texts[$fallback_locale])) return $texts[$fallback_locale];

        return '';
    }
}

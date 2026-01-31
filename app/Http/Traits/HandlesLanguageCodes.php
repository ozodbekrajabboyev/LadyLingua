<?php

namespace App\Http\Traits;

use App\Models\AvailableLanguage;

trait HandlesLanguageCodes
{
    /**
     * Get language code for display based on available languages in the database
     */
    protected function getLanguageCode($languageName)
    {
        // Cache the language mapping to avoid multiple DB queries
        static $languageMapping = null;

        if ($languageMapping === null) {
            $languageMapping = $this->buildLanguageMapping();
        }

        return $languageMapping[$languageName] ?? strtoupper(substr($languageName, 0, 2));
    }

    /**
     * Build language code mapping from database or fallback to static mapping
     */
    private function buildLanguageMapping()
    {
        try {
            // Try to get languages from database
            if (class_exists('App\Models\AvailableLanguage') && app()->bound('db')) {
                $availableLanguages = AvailableLanguage::all()->pluck('lang_name')->toArray();

                $mapping = [];
                foreach ($availableLanguages as $languageName) {
                    $mapping[$languageName] = $this->getStandardLanguageCode($languageName);
                }

                return $mapping;
            }
        } catch (\Exception $e) {
            // Fall back to static mapping if database is not available
        }

        // Fallback to static mapping
        return $this->getStaticLanguageMapping();
    }

    /**
     * Get static language mapping for fallback
     */
    private function getStaticLanguageMapping()
    {
        return [
            'English' => 'EN',
            'Spanish' => 'ES',
            'French' => 'FR',
            'German' => 'DE',
            'Italian' => 'IT',
            'Portuguese' => 'PT',
            'Russian' => 'RU',
            'Chinese' => 'CN',
            'Japanese' => 'JP',
            'Korean' => 'KR',
            'Uzbek' => 'UZ',
        ];
    }

    /**
     * Get standard language codes for known languages
     */
    private function getStandardLanguageCode($languageName)
    {
        $standardCodes = [
            'English' => 'EN',
            'French' => 'FR',
            'Russian' => 'RU',
            'Uzbek' => 'UZ',
            'Arabic' => 'AR',
            'Spanish' => 'ES',
            'German' => 'DE',
            'Italian' => 'IT',
            'Chinese' => 'CN',
            'Japanese' => 'JP',
            'Korean' => 'KR',
            'Turkish' => 'TR',
            'Portuguese' => 'PT',
        ];

        return $standardCodes[$languageName] ?? strtoupper(substr($languageName, 0, 2));
    }
}

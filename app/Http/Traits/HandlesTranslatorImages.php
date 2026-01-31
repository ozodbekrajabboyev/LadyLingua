<?php

namespace App\Http\Traits;

trait HandlesTranslatorImages
{
    /**
     * Get properly formatted translator image URL with fallback to initials avatar
     */
    protected function getTranslatorImageUrl($profileImageUrl, $translatorName = null, $size = 64)
    {
        if (!empty($profileImageUrl)) {
            // If it's already a full URL (starts with http), return as is
            if (str_starts_with($profileImageUrl, 'http')) {
                return $profileImageUrl;
            }
            // If it's a local path, use asset() helper
            return asset('storage/' . ltrim($profileImageUrl, '/'));
        }

        // Generate initials-based avatar URL using UI Avatars service
        if ($translatorName) {
            $initials = $this->getInitials($translatorName);
            $backgroundColor = $this->getColorFromName($translatorName);
            return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&background=" . $backgroundColor . "&color=ffffff&size={$size}&font-size=0.5&rounded=true&bold=true";
        }

        // Final fallback to default avatar
        return asset('images/default-avatar.svg');
    }

    /**
     * Get initials from full name
     */
    protected function getInitials($name)
    {
        $parts = explode(' ', trim($name));
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }

    /**
     * Generate consistent color from name for avatar background
     */
    protected function getColorFromName($name)
    {
        $colors = [
            '6366f1', // indigo
            '8b5cf6', // violet
            '06b6d4', // cyan
            '10b981', // emerald
            'f59e0b', // amber
            'ef4444', // red
            'ec4899', // pink
            '84cc16', // lime
            'f97316', // orange
            '3b82f6', // blue
        ];

        $hash = md5($name);
        $index = hexdec(substr($hash, 0, 2)) % count($colors);
        return $colors[$index];
    }

    /**
     * Get language code for display
     */
    protected function getLanguageCode($languageName)
    {
        $codes = [
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
        ];

        return $codes[$languageName] ?? strtoupper(substr($languageName, 0, 2));
    }
}

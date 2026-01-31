<?php

namespace App\Http\Traits;

use HTMLPurifier;
use HTMLPurifier_Config;

trait SanitizesHtmlContent
{
    /**
     * Sanitize HTML content safely using HTML Purifier
     *
     * @param string|null $htmlContent
     * @param array $allowedTags Custom allowed tags (optional)
     * @return string|null
     */
    protected function sanitizeHtml($htmlContent, array $allowedTags = null)
    {
        if (empty($htmlContent)) {
            return null;
        }

        // Create HTML Purifier configuration
        $config = HTMLPurifier_Config::createDefault();

        // Set allowed HTML tags (default safe set)
        $defaultTags = ['p', 'br', 'strong', 'em', 'b', 'i', 'ul', 'ol', 'li', 'a[href]'];
        $tags = $allowedTags ?? $defaultTags;
        $config->set('HTML.Allowed', implode(',', $tags));

        // Security configurations
        $config->set('HTML.Nofollow', true); // Add rel="nofollow" to links
        $config->set('HTML.TargetBlank', true); // Open links in new tab
        $config->set('HTML.TidyLevel', 'heavy'); // Clean up HTML structure
        $config->set('AutoFormat.RemoveEmpty', true); // Remove empty tags
        $config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);

        // URI filtering for maximum security
        $config->set('URI.DisableExternalResources', true);
        $config->set('URI.DisableResources', true);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);

        // Prevent XSS attacks
        $config->set('Attr.EnableID', false);
        $config->set('HTML.SafeIframe', false);
        $config->set('HTML.SafeObject', false);
        $config->set('HTML.SafeEmbed', false);

        // Create purifier instance
        $purifier = new HTMLPurifier($config);

        // Purify the HTML content
        $cleanHtml = $purifier->purify($htmlContent);

        // If the result is just empty tags, return plain text instead
        $plainText = strip_tags($cleanHtml);
        if (empty(trim($plainText))) {
            return strip_tags($htmlContent);
        }

        return $cleanHtml;
    }

    /**
     * Sanitize HTML content for biography/description fields
     *
     * @param string|null $bioContent
     * @return string|null
     */
    protected function sanitizeBio($bioContent)
    {
        return $this->sanitizeHtml($bioContent);
    }

    /**
     * Strip all HTML tags and return plain text only
     *
     * @param string|null $htmlContent
     * @return string|null
     */
    protected function stripHtml($htmlContent)
    {
        if (empty($htmlContent)) {
            return null;
        }

        // Convert HTML to plain text with proper spacing
        $text = strip_tags($htmlContent);
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}

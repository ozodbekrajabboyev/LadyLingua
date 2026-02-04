<?php

namespace App\Helpers;

use Exception;

class PdfHelper
{
    /**
     * Validate and sanitize PDF path for iframe usage
     *
     * @param string $path
     * @return string|null
     */
    public static function validatePdfPath($path)
    {
        // Remove any potential path traversal attempts
        $path = str_replace(['../', '.\\', '\\'], '', $path);

        // Ensure it's a PDF file
        if (!str_ends_with(strtolower($path), '.pdf')) {
            return null;
        }

        // Ensure the file exists in public directory
        $fullPath = public_path($path);
        if (!file_exists($fullPath)) {
            return null;
        }

        // Validate file type if fileinfo extension is available
        if (function_exists('mime_content_type')) {
            $mimeType = mime_content_type($fullPath);
            if ($mimeType !== 'application/pdf') {
                return null;
            }
        }

        return $path;
    }

    /**
     * Get PDF page count (requires pdfinfo or similar tool)
     *
     * @param string $path
     * @return int
     */
    public static function getPdfPageCount($path)
    {
        $fullPath = public_path($path);

        if (!file_exists($fullPath)) {
            return 1;
        }

        try {
            // Try using pdfinfo command if available
            $output = shell_exec("pdfinfo '{$fullPath}' | grep Pages");
            if ($output && preg_match('/Pages:\s*(\d+)/', $output, $matches)) {
                return (int)$matches[1];
            }
        } catch (Exception $e) {
            // Fallback to default if command fails
        }

        // Fallback: try to read PDF header (basic implementation)
        try {
            $handle = fopen($fullPath, 'rb');
            if ($handle) {
                $content = fread($handle, 8192); // Read first 8KB
                fclose($handle);

                // Count /Page occurrences (very basic method)
                $pageCount = substr_count($content, '/Page');
                if ($pageCount > 0) {
                    return $pageCount;
                }
            }
        } catch (Exception $e) {
            // Return default if all methods fail
        }

        return 1; // Default fallback
    }

    /**
     * Generate secure iframe parameters
     *
     * @param string $path
     * @param array $options
     * @return string
     */
    public static function generateIframeParams($path, $options = [])
    {
        $params = [];

        // Default parameters for PDF viewer
        $params['toolbar'] = $options['toolbar'] ?? '1';
        $params['navpanes'] = $options['navpanes'] ?? '0';
        $params['scrollbar'] = $options['scrollbar'] ?? '1';
        $params['view'] = $options['view'] ?? 'FitH';

        if (isset($options['page'])) {
            $params['page'] = (int)$options['page'];
        }

        if (isset($options['zoom'])) {
            $params['zoom'] = (int)$options['zoom'];
        }

        return '#' . http_build_query($params);
    }
}

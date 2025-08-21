<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Exception;

class TranslationService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    /**
     * Translate text from Vietnamese to English
     */
    public function translateToEnglish(string $text): string
    {
        try {
            if (empty(trim($text))) {
                return '';
            }

            $this->translator->setSource('vi');
            $this->translator->setTarget('en');
            
            return $this->translator->translate($text);
        } catch (Exception $e) {
            // Log error and return original text if translation fails
            \Log::error('Translation failed: ' . $e->getMessage());
            return $text;
        }
    }

    /**
     * Translate text from English to Vietnamese
     */
    public function translateToVietnamese(string $text): string
    {
        try {
            if (empty(trim($text))) {
                return '';
            }

            $this->translator->setSource('en');
            $this->translator->setTarget('vi');
            
            return $this->translator->translate($text);
        } catch (Exception $e) {
            // Log error and return original text if translation fails
            \Log::error('Translation failed: ' . $e->getMessage());
            return $text;
        }
    }

    /**
     * Auto-detect language and translate accordingly
     */
    public function autoTranslate(string $text, string $targetLanguage = 'en'): string
    {
        try {
            if (empty(trim($text))) {
                return '';
            }

            // Detect source language
            $detectedLang = $this->translator->getLastDetectedSource();
            
            if ($targetLanguage === 'en') {
                return $this->translateToEnglish($text);
            } else {
                return $this->translateToVietnamese($text);
            }
        } catch (Exception $e) {
            \Log::error('Auto translation failed: ' . $e->getMessage());
            return $text;
        }
    }

    /**
     * Detect text language
     */
    public function detectLanguage(string $text): string
    {
        try {
            $this->translator->translate($text);
            return $this->translator->getLastDetectedSource();
        } catch (Exception $e) {
            return 'unknown';
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TranslationController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Translate text to English
     */
    public function translateToEnglish(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:5000'
        ]);

        $translatedText = $this->translationService->translateToEnglish($request->text);

        return response()->json([
            'success' => true,
            'original' => $request->text,
            'translated' => $translatedText,
            'source_lang' => 'vi',
            'target_lang' => 'en'
        ]);
    }

    /**
     * Translate text to Vietnamese
     */
    public function translateToVietnamese(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:5000'
        ]);

        $translatedText = $this->translationService->translateToVietnamese($request->text);

        return response()->json([
            'success' => true,
            'original' => $request->text,
            'translated' => $translatedText,
            'source_lang' => 'en',
            'target_lang' => 'vi'
        ]);
    }

    /**
     * Auto-detect and translate
     */
    public function autoTranslate(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'target_lang' => 'required|string|in:en,vi'
        ]);

        $translatedText = $this->translationService->autoTranslate(
            $request->text, 
            $request->target_lang
        );

        return response()->json([
            'success' => true,
            'original' => $request->text,
            'translated' => $translatedText,
            'target_lang' => $request->target_lang
        ]);
    }

    /**
     * Detect text language
     */
    public function detectLanguage(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:1000'
        ]);

        $detectedLang = $this->translationService->detectLanguage($request->text);

        return response()->json([
            'success' => true,
            'text' => $request->text,
            'detected_language' => $detectedLang
        ]);
    }
}
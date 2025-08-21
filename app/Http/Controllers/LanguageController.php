<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'vi'])) {
            session()->put('locale', $locale);
            \Log::info('Language switched to: ' . $locale);
        }
        
        return redirect()->back();
    }
}

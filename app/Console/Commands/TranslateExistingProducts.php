<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Services\TranslationService;

class TranslateExistingProducts extends Command
{
    protected $signature = 'products:translate-existing';
    protected $description = 'Translate existing products to English using Google Translate';

    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        parent::__construct();
        $this->translationService = $translationService;
    }

    public function handle()
    {
        $this->info('🌐 Starting translation of existing products...');

        // Get products that don't have English translations
        $products = Product::whereNull('name_en')
                           ->orWhereNull('description_en')
                           ->get();

        if ($products->count() === 0) {
            $this->info('✅ All products already have English translations!');
            return;
        }

        $this->info("Found {$products->count()} products that need translation.");

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $successCount = 0;
        $errorCount = 0;

        foreach ($products as $product) {
            try {
                $updated = false;

                // Translate name if missing
                if (empty($product->name_en) && !empty($product->name)) {
                    $translatedName = $this->translationService->translateToEnglish($product->name);
                    $product->name_en = $translatedName;
                    $updated = true;
                    $this->line("\n✅ Translated name: {$product->name} → {$translatedName}");
                }

                // Translate description if missing
                if (empty($product->description_en) && !empty($product->description)) {
                    $translatedDesc = $this->translationService->translateToEnglish($product->description);
                    $product->description_en = $translatedDesc;
                    $updated = true;
                    $this->line("✅ Translated description for: {$product->name}");
                }

                if ($updated) {
                    $product->save();
                    $successCount++;
                }

                // Add small delay to avoid hitting rate limits
                usleep(500000); // 0.5 seconds

            } catch (\Exception $e) {
                $this->error("\n❌ Error translating product {$product->name}: " . $e->getMessage());
                $errorCount++;
            }

            $bar->advance();
        }

        $bar->finish();

        $this->line("\n");
        $this->info("🎉 Translation completed!");
        $this->info("✅ Successfully translated: {$successCount} products");
        
        if ($errorCount > 0) {
            $this->warn("⚠️  Errors: {$errorCount} products");
        }

        $this->info("🔄 Please refresh your browser to see the changes!");
    }
}
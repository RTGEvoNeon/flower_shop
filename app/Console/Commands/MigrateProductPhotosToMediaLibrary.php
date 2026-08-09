<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateProductPhotosToMediaLibrary extends Command
{
    protected $signature = 'products:migrate-photos-to-media-library {--delete-source : Удалить исходные файлы после переноса}';

    protected $description = 'Перенести фото товаров из storage/app/public/products/{id} в Spatie MediaLibrary';

    public function handle(): int
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $deleteSource = (bool) $this->option('delete-source');

        Product::query()->orderBy('id')->chunk(50, function ($products) use ($imageExtensions, $deleteSource) {
            foreach ($products as $product) {
                $directory = "products/{$product->id}";

                if (! Storage::disk('public')->exists($directory)) {
                    continue;
                }

                if ($product->getMedia(Product::PHOTOS_COLLECTION)->isNotEmpty()) {
                    $this->line("Товар #{$product->id}: уже есть фото в MediaLibrary, пропускаю.");

                    continue;
                }

                $files = Storage::disk('public')->files($directory);
                sort($files);

                foreach ($files as $file) {
                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if (! in_array($extension, $imageExtensions, true)) {
                        continue;
                    }

                    $product
                        ->addMedia(Storage::disk('public')->path($file))
                        ->preservingOriginal($deleteSource === false)
                        ->toMediaCollection(Product::PHOTOS_COLLECTION);
                }

                $this->info("Товар #{$product->id}: перенесено ".count($files).' файл(ов).');

                if ($deleteSource) {
                    Storage::disk('public')->deleteDirectory($directory);
                }
            }
        });

        $this->info('Готово.');

        return self::SUCCESS;
    }
}

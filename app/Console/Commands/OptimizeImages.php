<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize
        {--force : Перегенерировать .webp, даже если он уже существует}
        {--quality=82 : Качество webp от 0 до 100}';

    protected $description = 'Генерирует .webp рядом с каждым .jpg/.jpeg/.png в storage/app/public';

    /**
     * Каталоги (диск public), в которых ищем изображения.
     */
    private const DIRECTORIES = ['products', 'wholesales'];

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $manager = ImageManager::usingDriver(Driver::class);
        $quality = (int) $this->option('quality');
        $force = (bool) $this->option('force');

        $converted = 0;
        $skipped = 0;
        $failed = 0;
        $savedBytes = 0;

        foreach (self::DIRECTORIES as $directory) {
            if (! $disk->exists($directory)) {
                continue;
            }

            foreach ($disk->allFiles($directory) as $file) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (! in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
                    continue;
                }

                $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file);

                if (! $force && $disk->exists($webpPath)) {
                    $skipped++;

                    continue;
                }

                try {
                    $originalSize = $disk->size($file);

                    $encoded = $manager->decodePath($disk->path($file))->encode(new WebpEncoder($quality));
                    $disk->put($webpPath, (string) $encoded);

                    $savedBytes += max(0, $originalSize - $disk->size($webpPath));
                    $converted++;
                } catch (\Throwable $e) {
                    $this->error("Ошибка для {$file}: {$e->getMessage()}");
                    $failed++;
                }
            }
        }

        $this->info("Готово. Сконвертировано: {$converted}, пропущено: {$skipped}, ошибок: {$failed}");
        $this->info('Экономия: '.$this->formatBytes($savedBytes));

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1_048_576) {
            return round($bytes / 1_048_576, 1).' МБ';
        }

        return round($bytes / 1024, 1).' КБ';
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OptimizeImagesConversionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_images_optimize_generates_webp_for_thumb_conversion(): void
    {
        Storage::fake('public');

        $product = Product::factory()->create();
        $product->addMedia($this->makeTestImage())->toMediaCollection(Product::PHOTOS_COLLECTION);

        $media = $product->refresh()->getFirstMedia(Product::PHOTOS_COLLECTION);
        $thumbPath = $media->getPathRelativeToRoot('thumb');

        $this->artisan('images:optimize')->assertSuccessful();

        $webpPath = preg_replace('/\.jpg$/i', '.webp', $thumbPath);

        Storage::disk('public')->assertExists($webpPath);
    }

    private function makeTestImage(): string
    {
        $path = tempnam(sys_get_temp_dir(), 'test_image_').'.jpg';
        $image = imagecreatetruecolor(1000, 1000);
        imagefill($image, 0, 0, imagecolorallocate($image, 200, 100, 50));
        imagejpeg($image, $path);

        return $path;
    }
}

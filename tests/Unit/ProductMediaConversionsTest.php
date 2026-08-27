<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductMediaConversionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploading_photo_generates_thumb_conversion_within_bounding_box(): void
    {
        Storage::fake('public');

        $product = Product::factory()->create();
        $product->addMedia($this->makeTestImage(1000, 1000))
            ->toMediaCollection(Product::PHOTOS_COLLECTION);

        $media = $product->refresh()->getFirstMedia(Product::PHOTOS_COLLECTION);

        $this->assertTrue($media->hasGeneratedConversion('thumb'));

        [$width, $height] = getimagesize($media->getPath('thumb'));

        $this->assertLessThanOrEqual(300, $width);
        $this->assertLessThanOrEqual(300, $height);
    }

    public function test_uploading_photo_generates_medium_conversion_within_bounding_box(): void
    {
        Storage::fake('public');

        $product = Product::factory()->create();
        $product->addMedia($this->makeTestImage(1000, 1000))
            ->toMediaCollection(Product::PHOTOS_COLLECTION);

        $media = $product->refresh()->getFirstMedia(Product::PHOTOS_COLLECTION);

        $this->assertTrue($media->hasGeneratedConversion('medium'));

        [$width, $height] = getimagesize($media->getPath('medium'));

        $this->assertLessThanOrEqual(800, $width);
        $this->assertLessThanOrEqual(800, $height);
    }

    public function test_main_image_url_with_thumb_conversion_points_to_thumb_file(): void
    {
        Storage::fake('public');

        $product = Product::factory()->create();
        $product->addMedia($this->makeTestImage(1000, 1000))
            ->toMediaCollection(Product::PHOTOS_COLLECTION);

        $url = $product->refresh()->mainImageUrl('thumb');

        $this->assertStringContainsString('/conversions/', $url);
        $this->assertStringContainsString('-thumb.jpg', $url);
    }

    public function test_main_image_url_falls_back_to_placeholder_without_photos(): void
    {
        $product = Product::factory()->create();

        $this->assertSame('/images/placeholder.jpg', $product->mainImageUrl('thumb'));
    }

    private function makeTestImage(int $width, int $height): string
    {
        $path = tempnam(sys_get_temp_dir(), 'test_image_').'.jpg';
        $image = imagecreatetruecolor($width, $height);
        imagefill($image, 0, 0, imagecolorallocate($image, 200, 100, 50));
        imagejpeg($image, $path);

        return $path;
    }
}

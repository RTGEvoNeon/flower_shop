<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductCatalogImageSizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_card_uses_thumb_conversion_instead_of_original_photo(): void
    {
        Storage::fake('public');

        $product = Product::factory()->create(['is_available' => true]);
        $product->addMedia($this->makeTestImage())->toMediaCollection(Product::PHOTOS_COLLECTION);

        $response = $this->get('/products');

        $media = $product->refresh()->getFirstMedia(Product::PHOTOS_COLLECTION);

        $response->assertOk();
        $response->assertSee($media->getUrl('thumb'), false);
        $response->assertDontSee($media->getUrl(), false);
    }

    public function test_catalog_card_prefers_webp_thumb_after_optimize_command_runs(): void
    {
        Storage::fake('public');

        $product = Product::factory()->create(['is_available' => true]);
        $product->addMedia($this->makeTestImage())->toMediaCollection(Product::PHOTOS_COLLECTION);

        $this->artisan('images:optimize')->assertSuccessful();

        $response = $this->get('/products');

        $media = $product->refresh()->getFirstMedia(Product::PHOTOS_COLLECTION);
        $webpThumbUrl = preg_replace('/\.jpg$/i', '.webp', $media->getUrl('thumb'));

        $response->assertOk();
        $response->assertSee($webpThumbUrl, false);
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

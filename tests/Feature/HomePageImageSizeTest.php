<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomePageImageSizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_bestsellers_card_uses_thumb_conversion_instead_of_original_photo(): void
    {
        Storage::fake('public');

        $product = Product::factory()->create(['is_available' => true]);
        $product->addMedia($this->makeTestImage())->toMediaCollection(Product::PHOTOS_COLLECTION);

        $response = $this->get('/');

        $media = $product->refresh()->getFirstMedia(Product::PHOTOS_COLLECTION);

        $response->assertOk();
        $response->assertDontSee($media->getUrl(), false);
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

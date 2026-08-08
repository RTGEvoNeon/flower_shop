<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        $uploadedPaths = $this->form->getState()['photos'] ?? [];
        /** @var Product $product */
        $product = $this->record;
        $directory = "products/{$product->id}";

        foreach ($uploadedPaths as $path) {
            $filename = basename($path);
            Storage::disk('public')->move($path, "{$directory}/{$filename}");
        }
    }
}

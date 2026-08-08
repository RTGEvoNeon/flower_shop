<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['photos'] = $this->currentPhotoPaths();

        return $data;
    }

    protected function afterSave(): void
    {
        $remainingPaths = $this->form->getState()['photos'] ?? [];
        /** @var Product $product */
        $product = $this->record;
        $directory = "products/{$product->id}";

        foreach ($this->currentPhotoPaths() as $existingPath) {
            if (! in_array($existingPath, $remainingPaths, true)) {
                Storage::disk('public')->delete($existingPath);
            }
        }

        foreach ($remainingPaths as $path) {
            if (str_starts_with($path, 'products/tmp/')) {
                $filename = basename($path);
                Storage::disk('public')->move($path, "{$directory}/{$filename}");
            }
        }
    }

    private function currentPhotoPaths(): array
    {
        /** @var Product $product */
        $product = $this->record;
        $directory = "products/{$product->id}";

        return Storage::disk('public')->exists($directory)
            ? Storage::disk('public')->files($directory)
            : [];
    }
}

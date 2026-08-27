<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class ProductImportCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_imported_product_gets_attached_to_matching_category(): void
    {
        // Категория 'wedding' уже существует благодаря baseline data-migration.
        $import = new ProductsImport;

        $rows = collect([
            [
                'id' => null,
                'name' => 'Свадебный тест-букет',
                'description' => null,
                'composition' => null,
                'size' => null,
                'care_instructions' => null,
                'seo_text' => null,
                'price' => 5000,
                'category' => 'wedding',
                'is_available' => 1,
            ],
        ]);

        foreach ($rows as $row) {
            $model = $import->model($row);
            $model?->save();
        }

        $import->afterImport();

        $product = Product::where('name', 'Свадебный тест-букет')->firstOrFail();
        $weddingCategory = Category::where('key', 'wedding')->firstOrFail();

        $this->assertTrue($product->categories()->where('categories.id', $weddingCategory->id)->exists());
    }

    public function test_reimporting_row_with_different_category_replaces_the_link(): void
    {
        $import = new ProductsImport;

        $row = [
            'id' => null,
            'name' => 'Товар со сменой категории',
            'description' => null,
            'composition' => null,
            'size' => null,
            'care_instructions' => null,
            'seo_text' => null,
            'price' => 3000,
            'category' => 'wedding',
            'is_available' => 1,
        ];

        $model = $import->model($row);
        $model?->save();
        $import->afterImport();

        $product = Product::where('name', 'Товар со сменой категории')->firstOrFail();

        // Повторный импорт того же товара (по id) с другой категорией.
        $updateImport = new ProductsImport;
        $updateRow = $row;
        $updateRow['id'] = $product->id;
        $updateRow['category'] = 'mono';

        $updateImport->model($updateRow);
        $updateImport->afterImport();

        $product->refresh();
        $categoryKeys = $product->categories()->pluck('key')->all();

        $this->assertSame(['mono'], $categoryKeys);
    }

    public function test_excel_import_facade_attaches_category_end_to_end(): void
    {
        $file = base_path('tests/Fixtures/products_import_category_test.xlsx');

        // Строим минимальный xlsx на лету через PhpSpreadsheet, чтобы не хранить бинарник в репозитории.
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray([
            ['id', 'name', 'description', 'composition', 'size', 'care_instructions', 'seo_text', 'price', 'category', 'is_available'],
            [null, 'Экспортный тест-букет', null, null, null, null, null, 4500, 'wedding', 1],
        ]);

        if (! is_dir(dirname($file))) {
            mkdir(dirname($file), recursive: true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($file);

        try {
            Excel::import(new ProductsImport, $file);

            $product = Product::where('name', 'Экспортный тест-букет')->firstOrFail();
            $weddingCategory = Category::where('key', 'wedding')->firstOrFail();

            $this->assertTrue($product->categories()->where('categories.id', $weddingCategory->id)->exists());
        } finally {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}

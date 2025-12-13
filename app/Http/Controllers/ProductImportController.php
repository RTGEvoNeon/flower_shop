<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductImportController extends Controller
{
    /**
     * Показать форму импорта
     */
    public function showForm()
    {
        return view('admin.products.import');
    }

    /**
     * Обработать загруженный файл
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // максимум 10MB
        ], [
            'file.required' => 'Пожалуйста, выберите файл для загрузки',
            'file.mimes' => 'Файл должен быть в формате Excel (.xlsx, .xls) или CSV',
            'file.max' => 'Размер файла не должен превышать 10MB',
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));

            return redirect()->back()->with('success', 'Товары успешно импортированы!');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = "Строка {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return redirect()->back()
                ->withErrors(['import' => 'Ошибки при импорте:'])
                ->with('import_errors', $errors);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['import' => 'Ошибка при импорте файла: ' . $e->getMessage()]);
        }
    }

    /**
     * Скачать шаблон Excel
     */
    public function downloadTemplate()
    {
        return Excel::download(
            new \App\Exports\ProductsTemplateExport,
            'shablon_tovarov.xlsx'
        );
    }
}

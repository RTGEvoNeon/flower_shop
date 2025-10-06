<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ImportController extends Controller
{
    /**
     * Показать форму загрузки Excel файла
     */
    public function index()
    {
        return view('admin.import', [
            'title' => 'Импорт товаров - Mindale'
        ]);
    }

    /**
     * Обработать загруженный Excel файл
     */
    public function import(Request $request)
    {
        // Валидация файла
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240' // Максимум 10MB
        ], [
            'file.required' => 'Выберите файл для загрузки',
            'file.file' => 'Загруженный файл не является валидным файлом',
            'file.mimes' => 'Файл должен быть в формате Excel (.xlsx, .xls) или CSV',
            'file.max' => 'Размер файла не должен превышать 10MB'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Импорт данных из Excel файла
            Excel::import(new ProductsImport, $request->file('file'));

            return redirect()->back()
                ->with('success', 'Товары успешно импортированы!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Строка {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->back()
                ->with('error', 'Ошибки валидации: ' . implode('; ', $errorMessages));
                
        } catch (\Exception $e) {
            \Log::error('Import error: ' . $e->getMessage(), [
                'file' => $request->file('file')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Ошибка при импорте: ' . $e->getMessage());
        }
    }

    /**
     * Скачать шаблон Excel файла
     */
    public function downloadTemplate()
    {
        $headers = [
            'ID',
            'Name (Название)',
            'slug',
            'Description (Описание)',
            'Category (Категория)',
            'Amount (Количество)',
            'Price (Цена)',
            'Is_available (1/0)',
            'Alt text (для SEO)'
        ];

        $sampleData = [
            [
                1,
                'Нежность',
                'nezhnost',
                'Романтичный букет из белых и розовых альстромерий в нежной розовой упаковке',
                'mono',
                21,
                0,
                1,
                'Букет из 21 альстромерии'
            ]
        ];

        $csv = fopen('php://temp', 'w+');
        
        // Записываем заголовки
        fputcsv($csv, $headers);
        
        // Записываем пример данных
        foreach ($sampleData as $row) {
            fputcsv($csv, $row);
        }
        
        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="products_template.csv"');
    }
}
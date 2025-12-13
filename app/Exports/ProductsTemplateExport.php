<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsTemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * Возвращает данные для экспорта (пример строк)
     */
    public function array(): array
    {
        return [
            [
                '',
                'Букет "Весенний"',
                'Нежный букет из тюльпанов и нарциссов',
                2500,
                'Букеты',
                1
            ],
            [
                '',
                'Композиция "Розовый рассвет"',
                'Элегантная композиция из роз',
                3500,
                'Композиции',
                1
            ],
        ];
    }

    /**
     * Заголовки таблицы
     */
    public function headings(): array
    {
        return [
            'id',
            'name',
            'description',
            'price',
            'category',
            'is_available'
        ];
    }

    /**
     * Стили для таблицы
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}

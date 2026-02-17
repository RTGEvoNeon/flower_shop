<?php

declare(strict_types=1);

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WholesaleProductsTemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * Возвращает данные для экспорта (пример строк)
     */
    public function array(): array
    {
        return [
            [
                '',
                'Тюльпаны Outlook',
                'outlook',
                50.00,
                47.00,
                45.00,
                1000,
                1
            ],
            [
                '',
                'Тюльпаны Presto',
                'presto',
                48.00,
                45.00,
                43.00,
                1000,
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
            'slug',
            'price_tier_1 (1000-4999)',
            'price_tier_2 (5000-9999)',
            'price_tier_3 (10000+)',
            'min_quantity',
            'is_available'
        ];
    }

    /**
     * Стили для таблицы
     */
    public function styles(Worksheet $sheet): array
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

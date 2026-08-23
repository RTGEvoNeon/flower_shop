<?php

declare(strict_types=1);

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
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
                '15 тюльпанов, 5 нарциссов, зелень, крафт-упаковка',
                'Диаметр 30 см, высота 45 см',
                'Подрежьте стебли под углом, меняйте воду раз в 2 дня, держите вдали от солнца.',
                'Букет «Весенний» — нежная композиция из свежих тюльпанов и нарциссов. Закажите доставку цветов в Брянске бесплатно по городу.',
                2500,
                'tulip',
                1,
            ],
            [
                '',
                'Композиция "Розовый рассвет"',
                'Элегантная композиция из роз',
                '25 кустовых роз, эвкалипт, гипсофила, дизайнерская упаковка',
                'Диаметр 40 см, высота 55 см',
                'Подрежьте стебли, держите в прохладной воде, меняйте воду ежедневно.',
                'Композиция «Розовый рассвет» из свежих роз — изысканный подарок. Бесплатная доставка цветов по Брянску в день заказа.',
                3500,
                'mix',
                1,
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
            'composition',
            'size',
            'care_instructions',
            'seo_text',
            'price',
            'category',
            'is_available',
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
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E2E8F0'],
                ],
            ],
        ];
    }
}

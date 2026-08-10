<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

/**
 * @property Form $form
 */
class PaymentSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Настройки оплаты';

    protected static ?string $title = 'Настройки оплаты';

    protected static string $view = 'filament.pages.payment-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'pay_enabled' => Setting::get('pay_enabled', false),
            'yookassa_shop_id' => Setting::get('yookassa_shop_id', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('pay_enabled')
                    ->label('Онлайн-оплата включена')
                    ->helperText('Если выключено, покупатели оформляют заявку без оплаты — как сейчас.'),
                Forms\Components\TextInput::make('yookassa_shop_id')
                    ->label('Идентификатор магазина (shop_id) в ЮKassa')
                    ->maxLength(255),
                Forms\Components\Placeholder::make('secret_key_note')
                    ->label('Секретный ключ ЮKassa')
                    ->content('Задаётся в переменной окружения YOOKASSA_SECRET_KEY на сервере и никогда не хранится в базе данных или интерфейсе.'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Setting::set('pay_enabled', (bool) $state['pay_enabled']);
        Setting::set('yookassa_shop_id', (string) $state['yookassa_shop_id']);

        Notification::make()
            ->title('Настройки оплаты сохранены')
            ->success()
            ->send();
    }
}

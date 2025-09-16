@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Политика конфиденциальности</h1>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-gray-600 mb-6">
                <strong>Дата последнего обновления:</strong> {{ date('d.m.Y') }}
            </p>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Общие положения</h2>
                <p class="text-gray-700 mb-4">
                    Настоящая Политика конфиденциальности (далее — «Политика») определяет порядок обработки персональных данных пользователей сайта Mindale.ru (далее — «Сайт»), принадлежащего ИП Редин Дмитрий Витальевич (далее — «Оператор»).
                </p>
                <p class="text-gray-700 mb-4">
                    Используя Сайт, вы соглашаетесь с условиями настоящей Политики. Если вы не согласны с какими-либо условиями, пожалуйста, не используйте Сайт.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. Какие данные мы собираем</h2>
                <p class="text-gray-700 mb-4">Мы можем собирать следующие категории персональных данных:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4">
                    <li>Контактная информация (имя, номер телефона, адрес электронной почты)</li>
                    <li>Адрес доставки</li>
                    <li>Информация о заказах и предпочтениях</li>
                    <li>Техническая информация (IP-адрес, тип браузера, операционная система)</li>
                    <li>Информация о посещениях сайта (страницы, время на сайте, источники перехода)</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. Цели обработки данных</h2>
                <p class="text-gray-700 mb-4">Мы используем ваши персональные данные для:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4">
                    <li>Обработки и выполнения заказов</li>
                    <li>Связи с вами по вопросам заказов</li>
                    <li>Доставки товаров</li>
                    <li>Предоставления клиентской поддержки</li>
                    <li>Улучшения качества наших услуг</li>
                    <li>Информирования о новых товарах и акциях (только с вашего согласия)</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. Правовые основания обработки</h2>
                <p class="text-gray-700 mb-4">
                    Обработка персональных данных осуществляется на основании:
                </p>
                <ul class="list-disc pl-6 text-gray-700 mb-4">
                    <li>Согласия субъекта персональных данных</li>
                    <li>Исполнения договора (обработка заказов)</li>
                    <li>Соблюдения правовых обязательств</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. Передача данных третьим лицам</h2>
                <p class="text-gray-700 mb-4">
                    Мы не продаем и не передаем ваши персональные данные третьим лицам, за исключением случаев:
                </p>
                <ul class="list-disc pl-6 text-gray-700 mb-4">
                    <li>Получения вашего явного согласия</li>
                    <li>Требований законодательства</li>
                    <li>Служб доставки (только для выполнения заказа)</li>
                    <li>Платежных систем (только для обработки платежей)</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. Безопасность данных</h2>
                <p class="text-gray-700 mb-4">
                    Мы принимаем все необходимые технические и организационные меры для защиты ваших персональных данных от несанкционированного доступа, изменения, раскрытия или уничтожения.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. Сроки хранения данных</h2>
                <p class="text-gray-700 mb-4">
                    Персональные данные хранятся в течение времени, необходимого для достижения целей обработки, но не более 5 лет с момента последнего взаимодействия, если иное не предусмотрено законодательством.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">8. Ваши права</h2>
                <p class="text-gray-700 mb-4">Вы имеете право:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4">
                    <li>Получать информацию об обработке ваших персональных данных</li>
                    <li>Требовать уточнения, блокирования или уничтожения данных</li>
                    <li>Отзывать согласие на обработку данных</li>
                    <li>Обращаться с жалобами в уполномоченные органы</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">9. Файлы cookie</h2>
                <p class="text-gray-700 mb-4">
                    Наш сайт использует файлы cookie для улучшения пользовательского опыта и анализа посещений. Вы можете отключить cookie в настройках вашего браузера.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">10. Изменения в Политике</h2>
                <p class="text-gray-700 mb-4">
                    Мы можем обновлять настоящую Политику. О существенных изменениях мы уведомим вас путем размещения обновленной версии на Сайте.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">11. Контактная информация</h2>
                <p class="text-gray-700 mb-4">
                    По всем вопросам, связанным с обработкой персональных данных, вы можете обращаться:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 mb-2"><strong>ИП Редин Дмитрий Витальевич</strong></p>
                    <p class="text-gray-700 mb-2">Телефон: <a href="tel:+79532929246" class="text-pink-600 hover:text-pink-700">+7 (953) 292-92-46</a></p>
                    <p class="text-gray-700">Адрес: г. Брянск</p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

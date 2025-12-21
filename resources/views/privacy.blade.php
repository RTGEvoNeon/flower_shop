@extends('layouts.app')

<x-seo.meta />

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden">
    <!-- Background Gradient Mesh -->
    <div class="absolute inset-0 gradient-mesh"></div>

    <!-- Decorative Elements -->
    <div class="absolute top-20 right-10 w-72 h-72 bg-primary-200/30 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 left-10 w-96 h-96 bg-gold-200/30 rounded-full blur-3xl animate-float" style="animation-delay: -3s;"></div>

    <div class="relative max-w-4xl mx-auto px-6 lg:px-8 py-20 lg:py-28">
        <div class="text-center space-y-6 animate-fade-in-up">
            <div class="inline-block">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm border border-accent-200 shadow-sm">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span class="text-sm font-medium text-accent-700">Защита персональных данных</span>
                </span>
            </div>

            <h1 class="font-display text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 leading-[0.95]">
                Политика<br/>
                <span class="relative inline-block">
                    <span class="relative z-10 bg-gradient-to-r from-primary-600 via-primary-500 to-gold-600 bg-clip-text text-transparent">конфиденциальности</span>
                    <svg class="absolute -bottom-2 left-0 w-full h-4 text-primary-300/50" viewBox="0 0 300 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 9C50 3 100 1 150 2C200 3 250 5 298 9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </span>
            </h1>

            <p class="text-lg text-gray-600">
                В соответствии с Федеральным законом от 27.07.2006 № 152-ФЗ «О персональных данных»
            </p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="relative py-20 bg-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">

        <!-- Section 1: Общие положения -->
        <div class="mb-16 animate-fade-in-up">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                    <span class="text-white font-display text-2xl font-bold">1</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Общие положения</h2>
                </div>
            </div>
            <div class="ml-20 space-y-4 text-gray-700 text-lg leading-relaxed">
                <p>
                    Настоящая политика обработки персональных данных составлена в соответствии с требованиями Федерального закона от 27.07.2006 № 152-ФЗ «О персональных данных» и определяет порядок обработки персональных данных и меры по обеспечению безопасности персональных данных, предпринимаемые <span class="font-semibold text-gray-900">ИП Редин Дмитрий Витальевич</span> (далее — Оператор).
                </p>
                <div class="p-6 bg-gradient-to-br from-primary-50 to-gold-50 rounded-2xl border border-primary-200">
                    <p class="font-semibold text-gray-900 mb-2">Цели политики:</p>
                    <ul class="space-y-2">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Защита прав и свобод человека и гражданина при обработке его персональных данных</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Защита права на неприкосновенность частной жизни, личную и семейную тайну</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌸</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 2: Основные понятия -->
        <div class="mb-16 animate-fade-in-up stagger-1">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-sage-500 to-sage-600 rounded-2xl flex items-center justify-center shadow-lg shadow-sage-500/20">
                    <span class="text-white font-display text-2xl font-bold">2</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Основные понятия, используемые в Политике</h2>
                </div>
            </div>
            <div class="ml-20 space-y-3 text-gray-700 text-lg leading-relaxed">
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Автоматизированная обработка персональных данных</span> — обработка персональных данных с помощью средств вычислительной техники.</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Блокирование персональных данных</span> — временное прекращение обработки персональных данных (за исключением случаев, если обработка необходима для уточнения персональных данных).</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Веб-сайт</span> — совокупность графических и информационных материалов, а также программ для ЭВМ и баз данных, обеспечивающих их доступность в сети интернет по сетевому адресу <span class="font-mono text-primary-700 bg-primary-50 px-2 py-0.5 rounded">{{ request()->getHost() }}</span>.</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Информационная система персональных данных</span> — совокупность содержащихся в базах данных персональных данных и обеспечивающих их обработку информационных технологий и технических средств.</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Обезличивание персональных данных</span> — действия, в результате которых невозможно определить без использования дополнительной информации принадлежность персональных данных конкретному Пользователю или иному субъекту персональных данных.</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Обработка персональных данных</span> — любое действие (операция) или совокупность действий (операций), совершаемых с использованием средств автоматизации или без использования таких средств с персональными данными, включая сбор, запись, систематизацию, накопление, хранение, уточнение (обновление, изменение), извлечение, использование, передачу (распространение, предоставление, доступ), обезличивание, блокирование, удаление, уничтожение персональных данных.</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Оператор</span> — государственный орган, муниципальный орган, юридическое или физическое лицо, самостоятельно или совместно с другими лицами организующие и/или осуществляющие обработку персональных данных, а также определяющие цели обработки персональных данных, состав персональных данных, подлежащих обработке, действия (операции), совершаемые с персональными данными.</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Персональные данные</span> — любая информация, относящаяся прямо или косвенно к определенному или определяемому Пользователю веб-сайта <span class="font-mono text-primary-700 bg-primary-50 px-2 py-0.5 rounded">{{ request()->getHost() }}</span>.</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                    <p><span class="font-semibold text-gray-900">Пользователь</span> — любой посетитель веб-сайта <span class="font-mono text-primary-700 bg-primary-50 px-2 py-0.5 rounded">{{ request()->getHost() }}</span>.</p>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌺</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 3: Права и обязанности Оператора -->
        <div class="mb-16 animate-fade-in-up stagger-2">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-gold-500 to-gold-600 rounded-2xl flex items-center justify-center shadow-lg shadow-gold-500/20">
                    <span class="text-white font-display text-2xl font-bold">3</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Права и обязанности Оператора</h2>
                </div>
            </div>
            <div class="ml-20 space-y-6 text-gray-700 text-lg leading-relaxed">
                <div>
                    <h3 class="font-display text-2xl font-semibold text-gray-900 mb-4">Оператор имеет право:</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-primary-50 rounded-xl border-l-4 border-primary-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                            <p>Получать от субъекта персональных данных достоверные информацию и/или документы, содержащие персональные данные</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-primary-50 rounded-xl border-l-4 border-primary-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                            <p>В случае отзыва субъектом персональных данных согласия на обработку персональных данных Оператор вправе продолжить обработку персональных данных без согласия субъекта персональных данных при наличии оснований, указанных в Законе о персональных данных</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-primary-50 rounded-xl border-l-4 border-primary-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                            <p>Самостоятельно определять состав и перечень мер, необходимых и достаточных для обеспечения выполнения обязанностей, предусмотренных Законом о персональных данных</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-display text-2xl font-semibold text-gray-900 mb-4">Оператор обязан:</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-sage-50 rounded-xl border-l-4 border-sage-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-sage-500 rounded-full mt-2"></div>
                            <p>Предоставлять субъекту персональных данных по его запросу информацию, касающуюся обработки его персональных данных</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-sage-50 rounded-xl border-l-4 border-sage-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-sage-500 rounded-full mt-2"></div>
                            <p>Организовывать обработку персональных данных в порядке, установленном действующим законодательством РФ</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-sage-50 rounded-xl border-l-4 border-sage-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-sage-500 rounded-full mt-2"></div>
                            <p>Отвечать на обращения и запросы субъектов персональных данных и их законных представителей в соответствии с требованиями Закона о персональных данных</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-sage-50 rounded-xl border-l-4 border-sage-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-sage-500 rounded-full mt-2"></div>
                            <p>Сообщать в уполномоченный орган по защите прав субъектов персональных данных по запросу этого органа необходимую информацию в течение 30 дней с даты получения такого запроса</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-sage-50 rounded-xl border-l-4 border-sage-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-sage-500 rounded-full mt-2"></div>
                            <p>Публиковать или иным образом обеспечивать неограниченный доступ к настоящей Политике обработки персональных данных</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-sage-50 rounded-xl border-l-4 border-sage-500">
                            <div class="flex-shrink-0 w-2 h-2 bg-sage-500 rounded-full mt-2"></div>
                            <p>Принимать правовые, организационные и технические меры для защиты персональных данных от неправомерного или случайного доступа к ним, уничтожения, изменения, блокирования, копирования, предоставления, распространения персональных данных, а также от иных неправомерных действий в отношении персональных данных</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌻</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 4: Права и обязанности субъектов персональных данных -->
        <div class="mb-16 animate-fade-in-up stagger-3">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                    <span class="text-white font-display text-2xl font-bold">4</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Основные права и обязанности субъектов персональных данных</h2>
                </div>
            </div>
            <div class="ml-20 space-y-6 text-gray-700 text-lg leading-relaxed">
                <div>
                    <h3 class="font-display text-2xl font-semibold text-gray-900 mb-4">Субъекты персональных данных имеют право:</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-accent-50 rounded-xl border-l-4 border-primary-500">
                            <div class="flex-shrink-0 w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">1</div>
                            <p>Получать информацию, касающуюся обработки его персональных данных, за исключением случаев, предусмотренных федеральными законами</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-accent-50 rounded-xl border-l-4 border-sage-500">
                            <div class="flex-shrink-0 w-8 h-8 bg-sage-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">2</div>
                            <p>Требовать от оператора уточнения его персональных данных, их блокирования или уничтожения в случае, если персональные данные являются неполными, устаревшими, неточными, незаконно полученными или не являются необходимыми для заявленной цели обработки</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-accent-50 rounded-xl border-l-4 border-gold-500">
                            <div class="flex-shrink-0 w-8 h-8 bg-gold-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">3</div>
                            <p>Принимать предусмотренные законом меры по защите своих прав</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-accent-50 rounded-xl border-l-4 border-primary-500">
                            <div class="flex-shrink-0 w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">4</div>
                            <p>Выдвигать условие предварительного согласия при обработке персональных данных в целях продвижения на рынке товаров, работ и услуг</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-accent-50 rounded-xl border-l-4 border-sage-500">
                            <div class="flex-shrink-0 w-8 h-8 bg-sage-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">5</div>
                            <p>Обжаловать действия или бездействие Оператора в уполномоченный орган по защите прав субъектов персональных данных или в судебном порядке</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-white to-accent-50 rounded-xl border-l-4 border-gold-500">
                            <div class="flex-shrink-0 w-8 h-8 bg-gold-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">6</div>
                            <p>На осуществление иных прав, предусмотренных законодательством РФ</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-display text-2xl font-semibold text-gray-900 mb-4">Субъекты персональных данных обязаны:</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-4 p-5 bg-white border-2 border-accent-200/50 rounded-xl">
                            <div class="flex-shrink-0 w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                            <p>Предоставлять Оператору достоверные данные о себе</p>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-white border-2 border-accent-200/50 rounded-xl">
                            <div class="flex-shrink-0 w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                            <p>Сообщать Оператору об уточнении (обновлении, изменении) своих персональных данных</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌷</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 5: Принципы обработки -->
        <div class="mb-16 animate-fade-in-up stagger-4">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-sage-500 to-sage-600 rounded-2xl flex items-center justify-center shadow-lg shadow-sage-500/20">
                    <span class="text-white font-display text-2xl font-bold">5</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Принципы обработки персональных данных</h2>
                </div>
            </div>
            <div class="ml-20 space-y-3 text-gray-700 text-lg leading-relaxed">
                <div class="p-5 bg-gradient-to-r from-primary-50 to-gold-50 rounded-xl border border-primary-200">
                    <p>Обработка персональных данных осуществляется на <span class="font-semibold text-gray-900">законной и справедливой</span> основе.</p>
                </div>
                <div class="p-5 bg-gradient-to-r from-sage-50 to-primary-50 rounded-xl border border-sage-200">
                    <p>Обработка персональных данных ограничивается достижением <span class="font-semibold text-gray-900">конкретных, заранее определенных и законных</span> целей. Не допускается обработка персональных данных, несовместимая с целями сбора персональных данных.</p>
                </div>
                <div class="p-5 bg-gradient-to-r from-gold-50 to-accent-50 rounded-xl border border-gold-200">
                    <p>Не допускается объединение баз данных, содержащих персональные данные, обработка которых осуществляется в <span class="font-semibold text-gray-900">целях, несовместимых между собой</span>.</p>
                </div>
                <div class="p-5 bg-gradient-to-r from-primary-50 to-sage-50 rounded-xl border border-primary-200">
                    <p>Обработке подлежат только персональные данные, которые отвечают целям их обработки.</p>
                </div>
                <div class="p-5 bg-gradient-to-r from-accent-50 to-primary-50 rounded-xl border border-accent-200">
                    <p>Содержание и объем обрабатываемых персональных данных соответствуют заявленным целям обработки. Не допускается <span class="font-semibold text-gray-900">избыточность</span> обрабатываемых персональных данных по отношению к заявленным целям их обработки.</p>
                </div>
                <div class="p-5 bg-gradient-to-r from-sage-50 to-gold-50 rounded-xl border border-sage-200">
                    <p>При обработке персональных данных обеспечивается <span class="font-semibold text-gray-900">точность персональных данных, их достаточность</span>, а в необходимых случаях и актуальность по отношению к целям обработки персональных данных.</p>
                </div>
                <div class="p-5 bg-gradient-to-r from-gold-50 to-primary-50 rounded-xl border border-gold-200">
                    <p>Хранение персональных данных осуществляется в форме, позволяющей определить субъекта персональных данных, не дольше, чем этого требуют цели обработки персональных данных.</p>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌼</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 6: Цели обработки -->
        <div class="mb-16 animate-fade-in-up stagger-5">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-gold-500 to-gold-600 rounded-2xl flex items-center justify-center shadow-lg shadow-gold-500/20">
                    <span class="text-white font-display text-2xl font-bold">6</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Цели обработки персональных данных</h2>
                </div>
            </div>
            <div class="ml-20 space-y-4 text-gray-700 text-lg leading-relaxed">
                <div class="p-6 bg-gradient-to-br from-primary-100 to-gold-100 rounded-2xl border-2 border-primary-300">
                    <p class="font-display text-xl font-semibold text-gray-900 mb-3">Основная цель обработки:</p>
                    <p class="text-gray-800">Информирование Пользователя посредством отправки электронных писем</p>
                </div>
                <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl">
                    <p><span class="font-semibold text-gray-900">Персональные данные:</span> философские убеждения</p>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌹</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 7: Условия обработки -->
        <div class="mb-16 animate-fade-in-up stagger-6">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                    <span class="text-white font-display text-2xl font-bold">7</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Условия обработки персональных данных</h2>
                </div>
            </div>
            <div class="ml-20 space-y-4 text-gray-700 text-lg leading-relaxed">
                <p>Обработка персональных данных осуществляется с согласия субъекта персональных данных на обработку его персональных данных.</p>
                <p>Обработка персональных данных необходима для следующих целей:</p>
                <div class="space-y-3 mt-6">
                    <div class="flex items-start gap-4 p-5 bg-accent-50 rounded-xl border border-accent-200/50">
                        <svg class="w-6 h-6 text-primary-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Достижение целей, предусмотренных международным договором Российской Федерации или законом</p>
                    </div>
                    <div class="flex items-start gap-4 p-5 bg-accent-50 rounded-xl border border-accent-200/50">
                        <svg class="w-6 h-6 text-sage-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Исполнение возложенных законодательством Российской Федерации на оператора функций, полномочий и обязанностей</p>
                    </div>
                    <div class="flex items-start gap-4 p-5 bg-accent-50 rounded-xl border border-accent-200/50">
                        <svg class="w-6 h-6 text-gold-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Исполнение договора, стороной которого либо выгодоприобретателем или поручителем по которому является субъект персональных данных</p>
                    </div>
                    <div class="flex items-start gap-4 p-5 bg-accent-50 rounded-xl border border-accent-200/50">
                        <svg class="w-6 h-6 text-primary-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Защита жизни, здоровья или иных жизненно важных интересов субъекта персональных данных</p>
                    </div>
                    <div class="flex items-start gap-4 p-5 bg-accent-50 rounded-xl border border-accent-200/50">
                        <svg class="w-6 h-6 text-sage-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Осуществление прав и законных интересов оператора или третьих лиц</p>
                    </div>
                    <div class="flex items-start gap-4 p-5 bg-accent-50 rounded-xl border border-accent-200/50">
                        <svg class="w-6 h-6 text-gold-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Осуществление профессиональной деятельности журналиста и (или) законной деятельности средства массовой информации</p>
                    </div>
                    <div class="flex items-start gap-4 p-5 bg-accent-50 rounded-xl border border-accent-200/50">
                        <svg class="w-6 h-6 text-primary-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Обработка персональных данных, доступ неограниченного круга лиц к которым предоставлен субъектом персональных данных</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">💐</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 8: Порядок сбора, хранения -->
        <div class="mb-16 animate-fade-in-up stagger-7">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-sage-500 to-sage-600 rounded-2xl flex items-center justify-center shadow-lg shadow-sage-500/20">
                    <span class="text-white font-display text-2xl font-bold">8</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Порядок сбора, хранения, передачи и других видов обработки персональных данных</h2>
                </div>
            </div>
            <div class="ml-20 space-y-4 text-gray-700 text-lg leading-relaxed">
                <p>
                    Безопасность персональных данных, которые обрабатываются Оператором, обеспечивается путем реализации правовых, организационных и технических мер, необходимых для выполнения в полном объеме требований действующего законодательства в области защиты персональных данных.
                </p>

                <div class="p-6 bg-gradient-to-br from-primary-50 to-gold-50 rounded-2xl border-2 border-primary-300 mt-6">
                    <p class="font-semibold text-gray-900 mb-3 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Гарантия конфиденциальности:
                    </p>
                    <p class="text-gray-800">Персональные данные Пользователя <span class="font-semibold">никогда</span> не будут переданы третьим лицам, за исключением случаев, связанных с исполнением действующего законодательства.</p>
                </div>

                <div class="p-6 bg-white border-2 border-accent-200/50 rounded-2xl mt-6">
                    <p class="font-semibold text-gray-900 mb-3">Право на отзыв согласия:</p>
                    <p>Пользователь в любой момент может изменить (обновить, дополнить) предоставленную им персональную информацию или её часть, а также параметры её конфиденциальности, отправив письмо Оператору на адрес электронной почты: <a href="mailto:edemskisadprivacy@yandex.ru" class="text-primary-600 hover:text-primary-700 font-medium underline">edemskisadprivacy@yandex.ru</a> с пометкой «Обновление персональных данных».</p>
                </div>

                <p class="mt-6 p-4 bg-gold-50 border-l-4 border-gold-500 rounded-r-xl">
                    <span class="font-semibold text-gray-900">Важно:</span> Оператор обеспечивает сохранность персональных данных и принимает все возможные меры, исключающие доступ к персональным данным неуполномоченных лиц.
                </p>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌸</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 9: Перечень действий -->
        <div class="mb-16 animate-fade-in-up stagger-8">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-gold-500 to-gold-600 rounded-2xl flex items-center justify-center shadow-lg shadow-gold-500/20">
                    <span class="text-white font-display text-2xl font-bold">9</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Перечень действий, производимых Оператором с полученными персональными данными</h2>
                </div>
            </div>
            <div class="ml-20 space-y-3 text-gray-700 text-lg leading-relaxed">
                <p class="mb-6">Оператор осуществляет следующие действия с персональными данными:</p>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Сбор</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-sage-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-sage-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-sage-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Запись</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-gold-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gold-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Систематизация</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Накопление</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-sage-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-sage-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-sage-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Хранение</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-gold-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gold-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Уточнение</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Извлечение</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-sage-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-sage-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-sage-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Использование</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-gold-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gold-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Передача</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Обезличивание</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-sage-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-sage-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-sage-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Блокирование</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-gold-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gold-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Удаление</p>
                        </div>
                    </div>
                    <div class="p-5 bg-white border-2 border-accent-200/50 rounded-xl hover:border-primary-300 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Уничтожение</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌺</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 10-11: Трансграничная передача и конфиденциальность -->
        <div class="mb-16 animate-fade-in-up stagger-9">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                    <span class="text-white font-display text-xl font-bold">10</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Трансграничная передача персональных данных</h2>
                </div>
            </div>
            <div class="ml-20 space-y-4 text-gray-700 text-lg leading-relaxed">
                <p>
                    Оператор до начала осуществления трансграничной передачи персональных данных обязан убедиться в том, что иностранным государством, на территорию которого предполагается осуществлять передачу персональных данных, обеспечивается надежная защита прав субъектов персональных данных.
                </p>
                <div class="p-6 bg-gradient-to-br from-accent-50 to-primary-50 rounded-2xl border border-accent-200 mt-6">
                    <p class="font-semibold text-gray-900 mb-2">Конфиденциальность персональных данных:</p>
                    <p>Оператор и иные лица, получившие доступ к персональным данным, обязаны не раскрывать третьим лицам и не распространять персональные данные без согласия субъекта персональных данных, если иное не предусмотрено федеральным законом.</p>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400">🌻</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Section 12: Заключительные положения -->
        <div class="mb-16 animate-fade-in-up stagger-10">
            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-sage-500 to-sage-600 rounded-2xl flex items-center justify-center shadow-lg shadow-sage-500/20">
                    <span class="text-white font-display text-xl font-bold">12</span>
                </div>
                <div>
                    <h2 class="font-display text-3xl font-bold text-gray-900 mb-4">Заключительные положения</h2>
                </div>
            </div>
            <div class="ml-20 space-y-4 text-gray-700 text-lg leading-relaxed">
                <p>
                    Пользователь может получить любые разъяснения по интересующим вопросам, касающимся обработки его персональных данных, обратившись к Оператору с помощью электронной почты <a href="mailto:edemskisadprivacy@yandex.ru" class="text-primary-600 hover:text-primary-700 font-medium underline">edemskisadprivacy@yandex.ru</a>.
                </p>
                <p>
                    В данном документе будут отражены любые изменения политики обработки персональных данных Оператором. Политика действует бессрочно до замены ее новой версией.
                </p>
                <p>
                    Актуальная версия Политики в свободном доступе расположена в сети Интернет по адресу <span class="font-mono text-primary-700 bg-primary-50 px-2 py-0.5 rounded">{{ request()->getSchemeAndHttpHost() }}/privacy</span>.
                </p>
            </div>
        </div>

        <!-- Contact Card -->
        <div class="relative my-20 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-500 to-gold-600 rounded-3xl"></div>
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-white rounded-full blur-3xl"></div>
            </div>
            <div class="relative p-10 lg:p-12">
                <div class="text-center mb-8">
                    <h2 class="font-display text-3xl lg:text-4xl font-bold text-white mb-3">Реквизиты Оператора</h2>
                    <p class="text-white/90 text-lg">По всем вопросам обработки персональных данных</p>
                </div>
                <div class="max-w-3xl mx-auto space-y-4 text-white">
                    <div class="p-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl">
                        <p class="text-xl font-semibold mb-2">ИП Редин Дмитрий Витальевич</p>
                        <div class="space-y-2 text-white/90">
                            <p>г. Брянск, ул. Академика Сахарова, 5</p>
                            <p>Телефон: <a href="tel:+79532929246" class="hover:text-white transition-colors">+7 (953) 292-92-46</a></p>
                            <p>Email для вопросов о персональных данных: <a href="mailto:edemskisadprivacy@yandex.ru" class="hover:text-white transition-colors underline">edemskisadprivacy@yandex.ru</a></p>
                            <p>Telegram: <a href="https://t.me/FlowersMindale" class="hover:text-white transition-colors underline">@FlowersMindale</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-16">
            <a href="/" class="group inline-flex items-center gap-3 px-8 py-4 border-2 border-primary-400 text-primary-700 rounded-full font-semibold hover:bg-primary-50 transition-all hover:scale-105 shadow-sm">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                <span>Вернуться на главную</span>
            </a>
        </div>
    </div>
</section>

@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Импорт товаров</h1>
            <p class="text-gray-600">Загрузите Excel файл с товарами для массового добавления в каталог</p>
        </div>

        <!-- Уведомления -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm text-red-800">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Форма загрузки -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <form action="{{ route('admin.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Выберите Excel файл (.xlsx, .xls) или CSV
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-pink-600 hover:text-pink-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-pink-500">
                                    <span>Загрузить файл</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required>
                                </label>
                                <p class="pl-1">или перетащите сюда</p>
                            </div>
                            <p class="text-xs text-gray-500">Excel файлы до 10MB</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="bg-pink-600 text-white px-8 py-3 rounded-lg hover:bg-pink-700 transition-colors font-medium">
                        Импортировать товары
                    </button>
                </div>
            </form>
        </div>

        <!-- Информация о формате -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Структура файла -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Структура файла</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID:</span>
                        <span class="font-medium">Автоинкремент</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Name:</span>
                        <span class="font-medium">Название товара</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">slug:</span>
                        <span class="font-medium">URL-адрес (опционально)</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Description:</span>
                        <span class="font-medium">Описание</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Category:</span>
                        <span class="font-medium">Категория</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-medium">Количество</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Price:</span>
                        <span class="font-medium">Цена</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Is_available:</span>
                        <span class="font-medium">1 = доступен, 0 = недоступен</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Alt text:</span>
                        <span class="font-medium">SEO описание</span>
                    </div>
                </div>
            </div>

            <!-- Пример данных -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Пример данных</h3>
                <div class="bg-gray-50 rounded p-4 text-sm font-mono">
                    <div class="text-gray-600 mb-2">// Первая строка - заголовки</div>
                    <div class="space-y-1 text-xs">
                        <div>ID,Name,slug,Description,Category,Amount,Price,Is_available,Alt text</div>
                        <div class="text-gray-500">1,Нежность,nezhnost,"Романтичный букет...",mono,21,0,1,"Букет из 21 альстромерии"</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Скачать шаблон -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-4">Нужен шаблон для заполнения?</p>
            <a href="{{ route('admin.import.template') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Скачать шаблон CSV
            </a>
        </div>
    </div>
</div>

<script>
// Drag and drop functionality
const dropZone = document.querySelector('[class*="border-dashed"]');
const fileInput = document.getElementById('file');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-pink-400', 'bg-pink-50');
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-pink-400', 'bg-pink-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-pink-400', 'bg-pink-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
    }
});
</script>
@endsection

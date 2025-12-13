@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-lg border border-accent-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-500 to-gold-600 px-8 py-6">
            <h1 class="text-3xl font-display font-semibold text-white">Импорт товаров из Excel</h1>
            <p class="text-white/80 mt-2">Загрузите Excel файл с товарами для добавления в каталог</p>
        </div>

        <div class="p-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <div class="flex-1">
                            <span class="text-red-800 font-medium block mb-2">{{ $errors->first('import') }}</span>
                            @if(session('import_errors'))
                                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                                    @foreach(session('import_errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            @foreach($errors->all() as $error)
                                @if($error !== $errors->first('import'))
                                    <p class="text-red-700 text-sm">{{ $error }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Instructions -->
            <div class="mb-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
                <h2 class="text-lg font-semibold text-blue-900 mb-3">Инструкция по импорту</h2>
                <ol class="list-decimal list-inside space-y-2 text-blue-800">
                    <li>Скачайте шаблон Excel файла (кнопка ниже)</li>
                    <li>Заполните файл данными о товарах</li>
                    <li>Обязательные колонки: <strong>название</strong>, <strong>цена</strong>, <strong>категория</strong></li>
                    <li>Загрузите заполненный файл на этой странице</li>
                </ol>

                <div class="mt-4">
                    <a href="{{ route('admin.products.import.template') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Скачать шаблон Excel
                    </a>
                </div>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('admin.products.import.process') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Выберите файл Excel
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Выберите файл</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required>
                                </label>
                                <p class="pl-1">или перетащите сюда</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                Excel файлы: .xlsx, .xls, .csv (макс. 10MB)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4">
                    <a href="/products" class="text-gray-600 hover:text-gray-900 transition-colors">
                        ← Вернуться к каталогу
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-gold-600 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-gold-700 transition-all shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Загрузить и импортировать
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Drag and drop functionality
const dropZone = document.querySelector('[class*="border-dashed"]');
const fileInput = document.getElementById('file');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => {
        dropZone.classList.add('border-primary-500', 'bg-primary-50');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => {
        dropZone.classList.remove('border-primary-500', 'bg-primary-50');
    }, false);
});

dropZone.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    fileInput.files = files;
}, false);

// Show file name after selection
fileInput.addEventListener('change', (e) => {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        const label = document.querySelector('label[for="file"] span');
        label.textContent = fileName;
    }
});
</script>
@endsection

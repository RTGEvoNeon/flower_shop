<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            
            // Связь с продуктом
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Пути к файлам
            $table->string('filename', 255); // Имя файла на диске
            $table->string('original_name', 255); // Оригинальное имя файла
            $table->string('path', 500); // Полный путь к файлу
            $table->string('url', 500)->nullable(); // URL для доступа
            
            // Метаданные изображения
            $table->string('mime_type', 100); // image/jpeg, image/png, etc.
            $table->unsignedInteger('file_size'); // Размер в байтах
            $table->unsignedSmallInteger('width')->nullable(); // Ширина в пикселях
            $table->unsignedSmallInteger('height')->nullable(); // Высота в пикселях
            
            // Порядок отображения и статус
            $table->unsignedTinyInteger('sort_order')->default(0); // Порядок (0-255)
            $table->boolean('is_primary')->default(false); // Главное изображение
            $table->boolean('is_active')->default(true); // Активно/неактивно
            
            // Дополнительные поля
            $table->string('alt_text', 255)->nullable(); // Alt текст для SEO
            $table->text('description')->nullable(); // Описание изображения
            
            $table->timestamps();
            
            // Примечание: ограничение на единственное главное изображение 
            // будет контролироваться в модели через mutator
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};

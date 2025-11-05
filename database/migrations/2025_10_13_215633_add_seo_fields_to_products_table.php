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
        Schema::table('products', function (Blueprint $table) {
            $table->string('flower_type')->nullable()->after('category'); // роза, хризантема, пион и т.д.
            $table->string('occasion')->nullable()->after('flower_type'); // день рождения, 8 марта, свадьба
            $table->string('style')->nullable()->after('occasion'); // в крафте, композиция, классический
            $table->string('price_range')->nullable()->after('style'); // недорого, премиум
            $table->json('tags')->nullable()->after('price_range'); // массив тегов для фильтрации

            // SEO поля
            $table->string('meta_title')->nullable()->after('tags');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['flower_type', 'occasion', 'style', 'price_range', 'tags', 'meta_title', 'meta_description', 'meta_keywords']);
        });
    }
};

<div
    x-data="{ visible: !localStorage.getItem('cookie_consent') }"
    x-show="visible"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-cloak
    class="fixed inset-x-0 bottom-0 z-[60] p-4 sm:p-6"
    role="dialog"
    aria-live="polite"
    aria-label="Уведомление об использовании cookie"
>
    <div class="max-w-3xl mx-auto bg-gray-900/95 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl p-5 sm:p-6 flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
        <p class="text-sm sm:text-base text-gray-300 leading-relaxed text-center sm:text-left">
            Мы используем файлы cookie для аналитики и улучшения работы сайта. Продолжая пользоваться сайтом, вы соглашаетесь с
            <a href="/privacy" class="text-primary-400 hover:text-primary-300 underline">Политикой конфиденциальности</a>.
        </p>
        <button
            type="button"
            @click="localStorage.setItem('cookie_consent', '1'); visible = false"
            class="shrink-0 px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 text-white rounded-full font-semibold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:scale-105 whitespace-nowrap"
        >
            Хорошо
        </button>
    </div>
</div>

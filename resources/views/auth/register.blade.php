<x-guest-layout>
    <!-- Заголовок -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-display font-bold text-primary-800 mb-2">Создать аккаунт</h2>
        <p class="text-sage-600 font-light">Присоединяйтесь к нашему сообществу</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="group">
            <label for="name" class="block text-sm font-medium text-sage-700 mb-2 transition-colors group-focus-within:text-primary-600">
                Имя
            </label>
            <div class="relative">
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="block w-full px-4 py-3.5 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                           focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                           transition-all duration-300 ease-out
                           hover:border-sage-300"
                    placeholder="Введите ваше имя"
                >
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-primary-400/0 via-gold-400/0 to-sage-400/0 opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
            </div>
            @error('name')
                <p class="mt-2 text-sm text-primary-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="group">
            <label for="email" class="block text-sm font-medium text-sage-700 mb-2 transition-colors group-focus-within:text-primary-600">
                Email
            </label>
            <div class="relative">
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    class="block w-full px-4 py-3.5 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                           focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                           transition-all duration-300 ease-out
                           hover:border-sage-300"
                    placeholder="you@example.com"
                >
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-primary-400/0 via-gold-400/0 to-sage-400/0 opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
            </div>
            @error('email')
                <p class="mt-2 text-sm text-primary-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div class="group">
            <label for="password" class="block text-sm font-medium text-sage-700 mb-2 transition-colors group-focus-within:text-primary-600">
                Пароль
            </label>
            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="block w-full px-4 py-3.5 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                           focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                           transition-all duration-300 ease-out
                           hover:border-sage-300"
                    placeholder="Минимум 8 символов"
                >
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-primary-400/0 via-gold-400/0 to-sage-400/0 opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
            </div>
            @error('password')
                <p class="mt-2 text-sm text-primary-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="group">
            <label for="password_confirmation" class="block text-sm font-medium text-sage-700 mb-2 transition-colors group-focus-within:text-primary-600">
                Подтвердите пароль
            </label>
            <div class="relative">
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="block w-full px-4 py-3.5 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                           focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                           transition-all duration-300 ease-out
                           hover:border-sage-300"
                    placeholder="Повторите пароль"
                >
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-primary-400/0 via-gold-400/0 to-sage-400/0 opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-sm text-primary-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full py-4 px-6 bg-primary-500
                       text-white font-semibold rounded-xl shadow-lg
                       hover:bg-primary-600 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]
                       focus:outline-none focus:ring-4 focus:ring-primary-200
                       transition-all duration-300 ease-out"
            >
                Зарегистрироваться
            </button>
        </div>

        <!-- Login Link -->
        <div class="pt-4 text-center border-t border-sage-200">
            <p class="text-sage-600">
                Уже есть аккаунт?
                <a
                    href="{{ route('login') }}"
                    class="font-medium text-primary-600 hover:text-primary-700 underline decoration-2 decoration-primary-300 underline-offset-4 hover:decoration-primary-500 transition-colors duration-200"
                >
                    Войти
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

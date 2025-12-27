// Мобильное меню с плавной анимацией
function initMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    
    if (!mobileMenuButton || !mobileMenu || !mobileMenuBackdrop) {
        return;
    }
    
    let isMenuOpen = false;

    function openMenu() {
        isMenuOpen = true;
        mobileMenuButton.classList.add('menu-open');
        mobileMenu.classList.add('menu-open');
        mobileMenuBackdrop.classList.add('menu-open');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        isMenuOpen = false;
        mobileMenuButton.classList.remove('menu-open');
        mobileMenu.classList.remove('menu-open');
        mobileMenuBackdrop.classList.remove('menu-open');
        document.body.style.overflow = '';
    }

    // Открытие меню по кнопке
    mobileMenuButton.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (isMenuOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Закрытие по кнопке X внутри меню
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            closeMenu();
        });
    }

    // Закрытие меню при клике на ссылку
    const mobileMenuLinks = mobileMenu.querySelectorAll('.mobile-menu-link');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', () => {
            closeMenu();
        });
    });

    // Закрытие меню при клике на backdrop
    mobileMenuBackdrop.addEventListener('click', () => {
        if (isMenuOpen) {
            closeMenu();
        }
    });

    // Закрытие меню по клавише Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isMenuOpen) {
            closeMenu();
        }
    });
}

// Инициализация: проверяем состояние DOM
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMobileMenu);
} else {
    initMobileMenu();
}

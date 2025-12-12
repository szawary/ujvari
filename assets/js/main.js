document.addEventListener('DOMContentLoaded', function () {
    registerLanguagePreference();
    initializeEventListeners();
    setupMobileMenu();
    initializeCookieConsent();

    const elementsWithOnclick = document.querySelectorAll('[onclick*="plusSlides"]');
    elementsWithOnclick.forEach(el => el.removeAttribute('onclick'));
});

// ===================================
// AUTOMATIKUS NYELV FELISMERÉS ÉS ÁTIRÁNYÍTÁS
// ===================================

const SUPPORTED_LANGUAGES = ['hu', 'de', 'en'];
const LANGUAGE_STORAGE_KEY = 'preferredLanguage';

(function enforcePreferredLanguage() {
    const currentLang = getCurrentPathLanguage() || getDocumentLanguage();
    const preferredLanguage = getStoredLanguage() || getBrowserPreferredLanguage();
    const targetLanguage = preferredLanguage || 'en';

    // Ha az URL-ben nincs nyelvi kód vagy eltér a preferenciától, tereljük át.
    if (!SUPPORTED_LANGUAGES.includes(currentLang)) {
        redirectToLanguage(targetLanguage);
        return;
    }

    if (preferredLanguage && preferredLanguage !== currentLang) {
        redirectToLanguage(preferredLanguage);
    }
})();

function getDocumentLanguage() {
    return (document.documentElement.getAttribute('lang') || 'en').toLowerCase();
}

function getStoredLanguage() {
    try {
        const stored = localStorage.getItem(LANGUAGE_STORAGE_KEY);
        if (stored && SUPPORTED_LANGUAGES.includes(stored)) {
            return stored;
        }
    } catch (error) {
        // Storage nem elérhető, lépjünk tovább alapértelmezett logikával
    }
    return null;
}

function getBrowserPreferredLanguage() {
    const navigatorLanguages = Array.isArray(navigator.languages) && navigator.languages.length > 0
        ? navigator.languages
        : [navigator.language || navigator.userLanguage || ''];

    for (const lang of navigatorLanguages) {
        if (!lang) continue;
        const normalized = lang.toLowerCase().slice(0, 2);
        if (SUPPORTED_LANGUAGES.includes(normalized)) {
            return normalized;
        }
    }

    return 'en';
}

function getCurrentPathLanguage() {
    const segments = window.location.pathname.split('/').filter(Boolean);
    const langFromPath = segments[0];
    if (SUPPORTED_LANGUAGES.includes(langFromPath)) {
        return langFromPath;
    }
    return null;
}

function redirectToLanguage(targetLanguage) {
    if (!SUPPORTED_LANGUAGES.includes(targetLanguage)) return;

    const segments = window.location.pathname.split('/').filter(Boolean);
    const currentPage = segments[1] || 'home';
    const remainingSegments = segments.slice(2);
    const rebuiltPath = ['/', targetLanguage, '/', currentPage].join('') + (remainingSegments.length ? '/' + remainingSegments.join('/') : '');
    const newUrl = rebuiltPath + window.location.search + window.location.hash;

    if (newUrl !== window.location.pathname + window.location.search + window.location.hash) {
        window.location.replace(newUrl);
    }
}

// ------------------------------------
// 7/B. NYELVVÁLASZTÁS ELMENTÉSE (MANUÁLIS FELÜLÍRÁS)
// ------------------------------------

function registerLanguagePreference() {
    const languageLinks = document.querySelectorAll('.language-selector a');

    languageLinks.forEach((link) => {
        link.addEventListener('click', () => {
            const href = link.getAttribute('href') || '';
            const segments = href.split('/').filter(Boolean);
            const lang = segments[0];

            if (SUPPORTED_LANGUAGES.includes(lang)) {
                try {
                    localStorage.setItem(LANGUAGE_STORAGE_KEY, lang);
                } catch (error) {
                    // Ha nem elérhető a storage, egyszerűen kihagyjuk az elmentést
                }
            }
        });
    });
}

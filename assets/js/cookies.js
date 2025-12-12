// ------------------------------------
// 8. COOKIE KEZELÉS ÉS GOOGLE ANALYTICS BLOKKOLÁS
// ------------------------------------

const GA_MEASUREMENT_ID = 'G-ZH63SMZVRQ';
const CONSENT_STORAGE_KEY = 'cookieConsent';

const COOKIE_TRANSLATIONS = {
    hu: {
        intro: 'A weboldal statisztikai célból Google Analytics sütiket használ.',
        necessaryTitle: 'Szükséges cookie-k',
        necessaryDescription: 'A weboldal működéséhez szükséges sütik.',
        analyticsTitle: 'Statisztikai cookie-k (Google Analytics)',
        analyticsDescription: 'A weboldal teljesítményének mérésére szolgálnak.',
        accept: 'Elfogadom',
        reject: 'Elutasítom',
        settings: 'Beállítások',
        settingsTitle: 'Cookie beállítások',
        save: 'Mentés',
        cancel: 'Mégse',
        manage: 'Cookie beállítások'
    },
    de: {
        intro: 'Diese Website verwendet Google Analytics Cookies zu statistischen Zwecken.',
        necessaryTitle: 'Notwendige Cookies',
        necessaryDescription: 'Für die Funktionsfähigkeit der Website erforderlich.',
        analyticsTitle: 'Statistische Cookies (Google Analytics)',
        analyticsDescription: 'Dienen zur Messung der Website-Performance.',
        accept: 'Ich stimme zu',
        reject: 'Ablehnen',
        settings: 'Einstellungen',
        settingsTitle: 'Cookie-Einstellungen',
        save: 'Speichern',
        cancel: 'Abbrechen',
        manage: 'Cookie-Einstellungen'
    },
    en: {
        intro: 'This website uses Google Analytics cookies for statistical purposes.',
        necessaryTitle: 'Necessary cookies',
        necessaryDescription: 'Required for the basic functionality of the website.',
        analyticsTitle: 'Analytics cookies (Google Analytics)',
        analyticsDescription: 'Used to measure website performance.',
        accept: 'Accept',
        reject: 'Reject',
        settings: 'Settings',
        settingsTitle: 'Cookie settings',
        save: 'Save',
        cancel: 'Cancel',
        manage: 'Cookie settings'
    }
};

let analyticsLoaded = false;
let analyticsScriptTag = null;

function initializeCookieConsent() {
    const consentBar = document.getElementById('cookie-consent');
    const settingsPanel = document.getElementById('cookie-settings');
    const manageButton = document.getElementById('cookie-manage');
    const analyticsToggle = document.getElementById('analytics-toggle');
    const saveButton = document.getElementById('cookie-settings-save');
    const cancelButton = document.getElementById('cookie-settings-cancel');
    const closeButton = document.querySelector('.cookie-settings__close');

    if (!consentBar || !settingsPanel) return;

    applyCookieTranslations();

    const savedConsent = getStoredConsent();

    if (savedConsent) {
        const allowAnalytics = savedConsent.analytics === true;
        updateAnalyticsState(allowAnalytics);
        if (analyticsToggle) {
            analyticsToggle.checked = allowAnalytics;
        }
        hideConsentBar();
        showManageButton();
    } else {
        showConsentBar();
    }

    consentBar.addEventListener('click', (event) => {
        const action = event.target?.getAttribute('data-action');
        if (!action) return;

        if (action === 'accept') {
            persistConsent({ status: 'accepted', analytics: true });
            updateAnalyticsState(true);
            hideConsentBar();
            showManageButton();
        } else if (action === 'reject') {
            persistConsent({ status: 'rejected', analytics: false });
            updateAnalyticsState(false);
            hideConsentBar();
            showManageButton();
        } else if (action === 'settings') {
            openSettings();
        }
    });

    if (manageButton) {
        manageButton.addEventListener('click', openSettings);
    }

    if (saveButton) {
        saveButton.addEventListener('click', () => {
            const allowAnalytics = analyticsToggle?.checked === true;
            persistConsent({ status: allowAnalytics ? 'accepted' : 'rejected', analytics: allowAnalytics });
            updateAnalyticsState(allowAnalytics);
            closeSettings();
            hideConsentBar();
            showManageButton();
        });
    }

    if (cancelButton) {
        cancelButton.addEventListener('click', closeSettings);
    }

    if (closeButton) {
        closeButton.addEventListener('click', closeSettings);
    }

    function openSettings() {
        if (analyticsToggle) {
            const currentConsent = getStoredConsent();
            analyticsToggle.checked = currentConsent ? currentConsent.analytics === true : false;
        }
        settingsPanel.classList.add('is-visible');
        hideConsentBar();
    }

    function closeSettings() {
        settingsPanel.classList.remove('is-visible');
    }

    function showConsentBar() {
        consentBar.classList.add('is-visible');
    }

    function hideConsentBar() {
        consentBar.classList.remove('is-visible');
    }

    function showManageButton() {
        manageButton?.classList.add('is-visible');
    }
}

function applyCookieTranslations() {
    const lang = getPageLanguage();
    const strings = COOKIE_TRANSLATIONS[lang] || COOKIE_TRANSLATIONS.en;
    const elements = document.querySelectorAll('[data-i18n]');

    elements.forEach((el) => {
        const key = el.getAttribute('data-i18n');
        if (strings[key]) {
            el.textContent = strings[key];
        }
    });
}

function getPageLanguage() {
    const lang = (document.documentElement.getAttribute('lang') || 'en').toLowerCase();
    if (COOKIE_TRANSLATIONS[lang]) {
        return lang;
    }
    return 'en';
}

function getStoredConsent() {
    try {
        const saved = localStorage.getItem(CONSENT_STORAGE_KEY);
        return saved ? JSON.parse(saved) : null;
    } catch (error) {
        return null;
    }
}

function persistConsent(consent) {
    try {
        localStorage.setItem(CONSENT_STORAGE_KEY, JSON.stringify(consent));
    } catch (error) {
        // Ignore storage errors
    }
}

function updateAnalyticsState(allowAnalytics) {
    window[`ga-disable-${GA_MEASUREMENT_ID}`] = !allowAnalytics;

    if (allowAnalytics) {
        loadAnalytics();
    } else {
        disableAnalytics();
    }
}

function loadAnalytics() {
    if (analyticsLoaded) return;

    analyticsScriptTag = document.createElement('script');
    analyticsScriptTag.async = true;
    analyticsScriptTag.src = `https://www.googletagmanager.com/gtag/js?id=${GA_MEASUREMENT_ID}`;

    analyticsScriptTag.onload = () => {
        window.dataLayer = window.dataLayer || [];
        function gtag() { window.dataLayer.push(arguments); }
        window.gtag = gtag;
        gtag('js', new Date());
        gtag('config', GA_MEASUREMENT_ID);
    };

    document.head.appendChild(analyticsScriptTag);
    analyticsLoaded = true;
}

function disableAnalytics() {
    if (analyticsScriptTag) {
        analyticsScriptTag.remove();
        analyticsScriptTag = null;
    }

    if (window.dataLayer && Array.isArray(window.dataLayer)) {
        window.dataLayer.length = 0;
    }

    if (typeof window.gtag === 'function') {
        window.gtag = function noop() {};
    }

    analyticsLoaded = false;
}

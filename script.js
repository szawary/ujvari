// ===================================
// LIGHTBOX GALÉRIA LOGIKA (CAROUSEL + ZOOM) - JAVÍTOTT VERZIÓ
// 
// MÓDOSÍTVA: A zoomLevels most már csak 1x és 2x nagyítást tartalmaz.
// ===================================

const lightbox = document.getElementById("lightbox");
const lightboxImg = document.getElementById("lightbox-img");
const triggers = document.getElementsByClassName("lightbox-trigger");

let currentGallery = []; 
let currentIndex = 0;    
let zoomLevel = 0;
// MÓDOSÍTÁS: Csak az 1x és 2x nagyítás maradt
const zoomLevels = [1, 2]; 

// ------------------------------------
// 1. GALÉRIA ADATOK ÖSSZEGYŰJTÉSE
// ------------------------------------

const galleryMap = new Map();
for (let i = 0; i < triggers.length; i++) {
    const trigger = triggers[i];
    const galleryId = trigger.getAttribute('data-gallery-id');
    const imageUrl = trigger.href;
    const index = parseInt(trigger.getAttribute('data-index'));

    // Biztonságosan kinyerjük az ALT szöveget a látható linkeknél
    const imageElement = trigger.querySelector('img');
    const altText = imageElement ? imageElement.alt : ''; 
    
    if (galleryId && !isNaN(index)) {
        if (!galleryMap.has(galleryId)) {
            galleryMap.set(galleryId, []);
        }
        galleryMap.get(galleryId).push({
            url: imageUrl,
            alt: altText,
            index: index 
        });
    }
}

// ------------------------------------
// 2. ESEMÉNYKEZELŐK BEÁLLÍTÁSA
// ------------------------------------

function initializeEventListeners() {
    // Bezáró gomb
    const closeButton = document.querySelector('.close-button');
    if (closeButton) {
        closeButton.addEventListener('click', closeLightbox);
    }
    
    // Előző gomb
    const prevButton = document.querySelector('.prev-button');
    if (prevButton) {
        prevButton.addEventListener('click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            plusSlides(-1);
        });
    }
    
    // Következő gomb
    const nextButton = document.querySelector('.next-button');
    if (nextButton) {
        nextButton.addEventListener('click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            plusSlides(1);
        });
    }
    
    // Lightbox kép (zoom)
    if (lightboxImg) {
        lightboxImg.addEventListener('click', zoomImage);
    }
    
    // Lightbox háttér (bezárás)
    if (lightbox) {
        lightbox.addEventListener('click', function(event) {
            if (event.target === lightbox) {
                closeLightbox(event);
            }
        });
    }
}

// ------------------------------------
// 3. GALÉRIA FUNKCIÓK
// ------------------------------------

// Kép megnyitása a Lightboxban
for (let i = 0; i < triggers.length; i++) {
    triggers[i].addEventListener('click', function(event) {
        event.preventDefault(); 
        
        const galleryId = this.getAttribute('data-gallery-id');
        const startIndex = parseInt(this.getAttribute('data-index')) || 0;

        if (galleryMap.has(galleryId)) {
            currentGallery = galleryMap.get(galleryId).sort((a, b) => a.index - b.index);
            currentIndex = startIndex;
        } else {
            const imageElement = this.querySelector('img'); 
            currentGallery = [{ 
                url: this.href, 
                alt: imageElement ? imageElement.alt : '', 
                index: 0 
            }];
            currentIndex = 0;
        }

        showSlide(currentIndex);
        lightbox.style.display = "block";
    });
}

// Kép betöltése
function showSlide(n) {
    if (currentGallery.length === 0) return;

    // Lapozás kezelése (körbe járás)
    if (n >= currentGallery.length) {
        currentIndex = 0;
    } else if (n < 0) {
        currentIndex = currentGallery.length - 1;
    } else {
        currentIndex = n;
    }

    const slide = currentGallery[currentIndex];
    lightboxImg.src = slide.url;
    lightboxImg.alt = slide.alt;
    
    updateNavigationButtons();
    
    // Zoom állapot visszaállítása lapozáskor
    lightboxImg.classList.remove('zoomed-in', 'zoomed-max');
    lightboxImg.style.transform = 'scale(1)';
    lightboxImg.style.transformOrigin = 'center center';
    zoomLevel = 0;
    
    // Görgetés vissza az elejére
    lightbox.scrollTo(0, 0);
    
    // Előbetöltés
    preloadImages(currentIndex);
}

// Lapozás funkció
function plusSlides(n) {
    showSlide(currentIndex + n);
}

// Navigációs gombok frissítése
function updateNavigationButtons() {
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const isCarousel = currentGallery.length > 1;

    if (prevButton) {
        prevButton.style.display = isCarousel ? 'block' : 'none';
    }
    if (nextButton) {
        nextButton.style.display = isCarousel ? 'block' : 'none';
    }
}

// Előbetöltés a gyors lapozásért
function preloadImages(n) {
    if (currentGallery.length <= 1) return;

    const prevIndex = (n - 1 + currentGallery.length) % currentGallery.length;
    const nextIndex = (n + 1) % currentGallery.length;

    const nextSlide = currentGallery[nextIndex];
    if (nextSlide && nextSlide.url) {
        new Image().src = nextSlide.url;
    }
    
    const prevSlide = currentGallery[prevIndex];
    if (prevSlide && prevSlide.url) {
        new Image().src = prevSlide.url;
    }
}

// ------------------------------------
// 4. ZOOM FUNKCIÓK
// ------------------------------------

function zoomImage(event) {
    if (currentGallery.length === 0) return; 
    
    event.stopPropagation();
    
    // MÓDOSÍTÁS: A zoomLevel most már csak 0 és 1 között vált (1x és 2x)
    zoomLevel = (zoomLevel + 1) % zoomLevels.length; 
    
    // Előző zoom szintek eltávolítása
    lightboxImg.classList.remove('zoomed-in', 'zoomed-max');
    
    if (zoomLevel === 1) { // Ha zoomLevel 1 (ami a 2x nagyítást jelenti)
        lightboxImg.classList.add('zoomed-max');
        lightboxImg.style.transform = `scale(${zoomLevels[1]})`; // scale(2)
        lightboxImg.style.transformOrigin = '0 0';
    } else { // Ha zoomLevel 0 (ami az 1x nagyítást jelenti)
        lightboxImg.style.transform = 'scale(1)';
        lightboxImg.style.transformOrigin = 'center center';
    }
    
    lightboxImg.style.transition = 'transform 0.3s ease';
    
    // Görgetés a nagyított képhez
    setTimeout(() => {
        const imgRect = lightboxImg.getBoundingClientRect();
        const lightboxRect = lightbox.getBoundingClientRect();
        
        // Ha a kép túlnyúlik, görgessünk középre
        if (imgRect.width > lightboxRect.width || imgRect.height > lightboxRect.height) {
            lightbox.scrollTo({
                top: lightboxImg.offsetTop - (lightbox.clientHeight / 2) + (imgRect.height / 2),
                left: lightboxImg.offsetLeft - (lightbox.clientWidth / 2) + (imgRect.width / 2),
                behavior: 'smooth'
            });
        }
    }, 100);
}

// ------------------------------------
// 5. BEZÁRÁS ÉS BILLENTYŰZET KEZELÉS
// ------------------------------------

function closeLightbox(event) {
    if (event) {
        event.stopPropagation();
    }
    
    lightbox.style.display = "none";
    lightboxImg.classList.remove('zoomed-in', 'zoomed-max');
    lightboxImg.style.transform = 'scale(1)';
    currentGallery = [];
    currentIndex = 0;
    zoomLevel = 0;
}

// Billentyűzet kezelés
document.addEventListener('keydown', function(event) {
    if (lightbox.style.display === 'block') {
        switch(event.key) {
            case 'Escape':
                closeLightbox(event);
                break;
            case 'ArrowLeft':
                plusSlides(-1);
                break;
            case 'ArrowRight':
                plusSlides(1);
                break;
        }
    }
});

// ------------------------------------
// 6. INITIALIZÁLÁS
// ------------------------------------

// Amikor az oldal betöltődik
document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();

    setupMobileMenu();

    initializeCookieConsent();

    // HTML onclick attribútumok eltávolítása
    const elementsWithOnclick = document.querySelectorAll('[onclick*="plusSlides"]');
    elementsWithOnclick.forEach(el => {
        el.removeAttribute('onclick');
    });
});

// ------------------------------------
// 7. MOBIL NAVIGÁCIÓ KEZELÉSE
// ------------------------------------

function setupMobileMenu() {
    const mainNav = document.querySelector('.main-nav');
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelectorAll('.main-nav ul a');

    if (!mainNav || !menuToggle) return;

    menuToggle.addEventListener('click', () => {
        const isOpen = mainNav.classList.toggle('open');
        menuToggle.setAttribute('aria-expanded', isOpen.toString());
    });

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (mainNav.classList.contains('open')) {
                mainNav.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
}

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
    }
}

function loadAnalytics() {
    if (analyticsLoaded) return;

    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${GA_MEASUREMENT_ID}`;

    script.onload = () => {
        window.dataLayer = window.dataLayer || [];
        function gtag() { window.dataLayer.push(arguments); }
        window.gtag = gtag;
        gtag('js', new Date());
        gtag('config', GA_MEASUREMENT_ID);
    };

    document.head.appendChild(script);
    analyticsLoaded = true;
}
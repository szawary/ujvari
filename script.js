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
    
    // HTML onclick attribútumok eltávolítása
    const elementsWithOnclick = document.querySelectorAll('[onclick*="plusSlides"]');
    elementsWithOnclick.forEach(el => {
        el.removeAttribute('onclick');
    });
});
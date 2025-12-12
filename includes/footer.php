<?php 
// Az index.php beállította a $FORDITASOK változót!
global $FORDITASOK;
?>
    </main>
<!--    
    <div id="lightbox" class="lightbox" onclick="closeLightbox(event)">
        <span class="close-button">&times;</span>
        <div class="lightbox-nav-button prev" onclick="plusSlides(-1, event)">&#10094;</div>
        <img class="lightbox-content" id="lightbox-img" onclick="zoomImage(event)">
        <div class="lightbox-nav-button next" onclick="plusSlides(1, event)">&#10095;</div>
        <div class="lightbox-caption" id="lightbox-caption"></div>
    </div>
-->
    <footer class="main-footer">
        <div class="contact-info">
            <p><strong><?php echo $FORDITASOK['kapcsolat_cim']; ?></strong> <a href="mailto:<?php echo $FORDITASOK['email']; ?>"><?php echo $FORDITASOK['email']; ?></a></p>
        </div>
        
        <div class="social-links">
            <a href="https://www.instagram.com/ujvari.agnes/" target="_blank" class="social-icon">Instagram</a>
        </div>
        
        <div class="copyright">
            <p><?php echo $FORDITASOK['lablec_jogok']; ?></p>
        </div>
    </footer>

    <!-- JAVÍTOTT HTML (csak a lightbox rész)--> 
    <div id="lightbox" class="lightbox">
        <span class="close-button">&times;</span>
    
        <a class="prev-button">&#10094;</a>
    
        <img class="lightbox-content" id="lightbox-img" src="" alt="Kinagyított ékszer">

        <a class="next-button">&#10095;</a>
    </div>

    <div class="cookie-consent" id="cookie-consent" role="dialog" aria-live="polite" aria-modal="true">
        <div class="cookie-consent__content">
            <div class="cookie-consent__text">
                <p class="cookie-consent__intro" data-i18n="intro">This website uses Google Analytics cookies for statistical purposes.</p>
                <div class="cookie-consent__options">
                    <div class="cookie-consent__option">
                        <strong data-i18n="necessaryTitle">Necessary cookies</strong>
                        <p data-i18n="necessaryDescription">Required for the basic functionality of the website.</p>
                    </div>
                    <div class="cookie-consent__option">
                        <strong data-i18n="analyticsTitle">Analytics cookies (Google Analytics)</strong>
                        <p data-i18n="analyticsDescription">Used to measure website performance.</p>
                    </div>
                </div>
            </div>
            <div class="cookie-consent__actions">
                <button type="button" class="cookie-btn primary" data-action="accept" data-i18n="accept">Accept</button>
                <button type="button" class="cookie-btn secondary" data-action="reject" data-i18n="reject">Reject</button>
                <button type="button" class="cookie-btn ghost" data-action="settings" data-i18n="settings">Settings</button>
            </div>
        </div>
    </div>

    <div class="cookie-settings" id="cookie-settings" role="dialog" aria-modal="true">
        <div class="cookie-settings__panel">
            <div class="cookie-settings__header">
                <h3 data-i18n="settingsTitle">Cookie settings</h3>
                <button type="button" class="cookie-settings__close" aria-label="Close settings">&times;</button>
            </div>
            <div class="cookie-settings__body">
                <div class="cookie-settings__row">
                    <div>
                        <strong data-i18n="necessaryTitle">Necessary cookies</strong>
                        <p data-i18n="necessaryDescription">Required for the basic functionality of the website.</p>
                    </div>
                    <label class="toggle disabled">
                        <input type="checkbox" checked disabled aria-disabled="true">
                        <span class="toggle__slider"></span>
                    </label>
                </div>
                <div class="cookie-settings__row">
                    <div>
                        <strong data-i18n="analyticsTitle">Analytics cookies (Google Analytics)</strong>
                        <p data-i18n="analyticsDescription">Used to measure website performance.</p>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="analytics-toggle">
                        <span class="toggle__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cookie-settings__footer">
                <button type="button" class="cookie-btn primary" id="cookie-settings-save" data-i18n="save">Save</button>
                <button type="button" class="cookie-btn ghost" id="cookie-settings-cancel" data-i18n="cancel">Cancel</button>
            </div>
        </div>
    </div>

    <button type="button" class="cookie-manage" id="cookie-manage" data-i18n="manage">Cookie settings</button>

    <script src="/assets/js/language.js"></script>
    <script src="/assets/js/lightbox.js"></script>
    <script src="/assets/js/menu.js"></script>
    <script src="/assets/js/cookies.js"></script>
    <script src="/assets/js/main.js" defer></script>

</body>
</html>
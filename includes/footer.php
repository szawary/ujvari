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

    <script src="/script.js"></script>

</body>
</html>
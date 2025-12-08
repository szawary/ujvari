<?php $kollekcio = $FORDITASOK['gallery_collection']; ?>

<section style="text-align: center; padding: 40px 0;">
    <h2><?php echo $FORDITASOK['gallery_intro_title']; ?></h2>
    <p><?php echo $FORDITASOK['gallery_intro_text']; ?></p>
</section>

<?php foreach ($kollekcio as $kategoria_id => $kategoria) : ?>
    <section class="category-section" id="<?php echo $kategoria_id; ?>">
        <h2><?php echo $kategoria['cim']; ?></h2>
        <div class="work-grid">
            <?php foreach ($kategoria['termekek'] as $termek) : 
                $base_url = $termek['kep_base'];
            ?>
                <div class="work-item">
                    <a href="<?php echo $base_url; ?>_1200.webp" class="lightbox-trigger">
                        <img 
                            src="<?php echo $base_url; ?>_450.webp"
                            srcset="<?php echo $base_url; ?>_450.webp 450w, <?php echo $base_url; ?>_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $termek['nev']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $termek['nev']; ?></h3>
                    <p><?php echo $termek['leiras']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endforeach; ?>

        <section class="about-me" id="bemutatkozas">
        <div class="text-content">
            <h2><?php echo $FORDITASOK['about_title']; ?></h2> 
            <p><?php echo $FORDITASOK['about_p1']; ?></p>
            <p><?php echo $FORDITASOK['about_p2']; ?></p>
            <p><?php echo $FORDITASOK['about_p3']; ?></p>
            <p><?php echo $FORDITASOK['about_p4']; ?></p>
        </div>
        <div class="image-content">
            <img src="../images/profil.jpg" alt="<?php echo $FORDITASOK['profile_alt'] ?? ''; ?>" class="profile-image">
        </div>
    </section>

       <section class="latest-works" id="latest">
            <h2><?php echo $FORDITASOK['section_title_01']; ?></h2>
            <div class="work-grid">
             <div class="work-item">
                    <a href="../images/1_cool/IMG_2586_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/1_cool/IMG_2586_450.webp"
                            srcset="../images/1_cool/IMG_2586_450.webp 450w, ../images/1_cool/IMG_2586_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_001']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_001']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_001']; ?></p>
                </div>
        
            <div class="work-item">
                    <a href="../images/1_cool/IMG_2382_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/1_cool/IMG_2382_450.webp"
                            srcset="../images/1_cool/IMG_2382_450.webp 450w, ../images/1_cool/IMG_2382_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_002']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_002']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_002']; ?></p>
                </div>
        
            <div class="work-item">
                    <a href="../images/1_cool/IMG_2530_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/1_cool/IMG_2530_450.webp"
                            srcset="../images/1_cool/IMG_2530_450.webp 450w, ../images/1_cool/IMG_2530_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_003']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_003']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_003']; ?></p>
                </div>
            </div>
    <a href="/<?php echo $nyelv; ?>/gallery" class="button button-secondary"><?php echo $FORDITASOK['all_items']; ?></a>

    </section>

        <section class="category-section" id="sets">
            <h2><?php echo $FORDITASOK['section_title_02']; ?></h2>
            <div class="work-grid">
                <div class="work-item">
                    <a href="../images/2_szettek/IMG_2489_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/2_szettek/IMG_2489_450.webp"
                            srcset="../images/2_szettek/IMG_2489_450.webp 450w, ../images/2_szettek/IMG_2489_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_004']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_004']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_004']; ?></p>
                </div>

            <div class="work-item">
                    <a href="../images/2_szettek/IMG_2589_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/2_szettek/IMG_2589_450.webp"
                            srcset="../images/2_szettek/IMG_2589_450.webp 450w, ../images/2_szettek/IMG_2589_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_005']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_005']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_005']; ?></p>
                </div>

            <div class="work-item">
                    <a href="../images/2_szettek/IMG_2494_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/2_szettek/IMG_2494_450.webp"
                            srcset="../images/2_szettek/IMG_2494_450.webp 450w, ../images/2_szettek/IMG_2494_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_006']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_006']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_006']; ?></p>
                </div>
            </div>
        <a href="/<?php echo $nyelv; ?>/gallery#sets" class="button button-secondary"><?php echo $FORDITASOK['all_sets']; ?></a>

        </section>

        <section class="category-section" id="earrings">
            <h2><?php echo $FORDITASOK['section_title_03']; ?></h2>
            <div class="work-grid">
                <div class="work-item">
                    <a href="../images/3_fulbevalok/IMG_2222_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/3_fulbevalok/IMG_2222_450.webp"
                            srcset="../images/3_fulbevalok/IMG_2222_450.webp 450w, ../images/3_fulbevalok/IMG_2222_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_007']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_007']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_007']; ?></p>
                </div>
                <div class="work-item">
                    <a href="../images/3_fulbevalok/IMG_2273_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/3_fulbevalok/IMG_2273_450.webp"
                            srcset="../images/3_fulbevalok/IMG_2273_450.webp 450w, ../images/3_fulbevalok/IMG_2273_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_008']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_008']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_008']; ?></p>
                </div>
                <div class="work-item">
                    <a href="../images/3_fulbevalok/IMG_2429_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/3_fulbevalok/IMG_2429_450.webp"
                            srcset="../images/3_fulbevalok/IMG_2429_450.webp 450w, ../images/3_fulbevalok/IMG_2429_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_009']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_009']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_009']; ?></p>
                </div>
            </div>
            <a href="/<?php echo $nyelv; ?>/gallery#earrings" class="button button-secondary"><?php echo $FORDITASOK['all_earrings']; ?></a>

        </section>

        <section class="category-section" id="bracelets">
            <h2><?php echo $FORDITASOK['section_title_04']; ?></h2>
            <div class="work-grid">
                <div class="work-item">
                    <a href="../images/4_karkotok/IMG_2443_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/4_karkotok/IMG_2443_450.webp"
                            srcset="../images/4_karkotok/IMG_2443_450.webp 450w, ../images/4_karkotok/IMG_2443_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_010']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_010']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_010']; ?></p>
                </div>
                <div class="work-item">
                    <a href="../images/4_karkotok/IMG_2249_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/4_karkotok/IMG_2249_450.webp"
                            srcset="../images/4_karkotok/IMG_2249_450.webp 450w, ../images/4_karkotok/IMG_2249_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_011']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_011']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_011']; ?></p>
                </div>
                <div class="work-item">
                    <a href="../images/4_karkotok/IMG_2514_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/4_karkotok/IMG_2514_450.webp"
                            srcset="../images/4_karkotok/IMG_2514_450.webp 450w, ../images/4_karkotok/IMG_2514_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_012']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_012']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_012']; ?></p>
                </div>
            </div>
        <a href="/<?php echo $nyelv; ?>/gallery#bracelets" class="button button-secondary"><?php echo $FORDITASOK['all_bracelets']; ?></a>
        </section>

        <section class="category-section" id="rings">
            <h2><?php echo $FORDITASOK['section_title_05']; ?></h2>
            <div class="work-grid">
                <div class="work-item">
                    <a href="../images/5_gyuruk/IMG_2318_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/5_gyuruk/IMG_2318_450.webp"
                            srcset="../images/5_gyuruk/IMG_2318_450.webp 450w, ../images/5_gyuruk/IMG_2318_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_013']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_013']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_013']; ?></p>
                </div>
                <div class="work-item">
                    <a href="../images/5_gyuruk/IMG_2600_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/5_gyuruk/IMG_2600_450.webp"
                            srcset="../images/5_gyuruk/IMG_2600_450.webp 450w, ../images/5_gyuruk/IMG_2600_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_014']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_014']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_014']; ?></p>
                </div>
                <div class="work-item">
                    <a href="../images/5_gyuruk/IMG_2545_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/5_gyuruk/IMG_2545_450.webp"
                            srcset="../images/5_gyuruk/IMG_2545_450.webp 450w, ../images/5_gyuruk/IMG_2545_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_015']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_015']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_015']; ?></p>
                </div>
            </div>
        <a href="/<?php echo $nyelv; ?>/gallery#rings" class="button button-secondary"><?php echo $FORDITASOK['all_rings']; ?></a>
        </section>

        <section class="category-section" id="smallThings">
            <h2><?php echo $FORDITASOK['section_title_06']; ?></h2>
            <div class="work-grid">
                <div class="work-item">
                    <a href="../images/6_aprosagok/IMG_2668_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/6_aprosagok/IMG_2668_450.webp"
                            srcset="../images/6_aprosagok/IMG_2668_450.webp 450w, ../images/6_aprosagok/IMG_2668_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_016']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_016']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_016']; ?></p>
                </div>
                <div class="work-item">
                    <a href="../images/6_aprosagok/IMG_2442_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/6_aprosagok/IMG_2442_450.webp"
                            srcset="../images/6_aprosagok/IMG_2442_450.webp 450w, ../images/6_aprosagok/IMG_2442_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_017']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_017']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_017']; ?></p>
                </div>
                <div class="work-item">
                    <a href="../images/6_aprosagok/IMG_2397_1200.webp" class="lightbox-trigger">
                        <img 
                            src="../images/6_aprosagok/IMG_2397_450.webp"
                            srcset="../images/6_aprosagok/IMG_2397_450.webp 450w, ../images/6_aprosagok/IMG_2397_900.webp 900w"
                            sizes="(max-width: 768px) 100vw, 33vw"
                            alt="<?php echo $FORDITASOK['item_name_018']; ?>"
                            loading="lazy">
                    </a>
                    <h3><?php echo $FORDITASOK['item_name_018']; ?></h3>
                    <p><?php echo $FORDITASOK['item_description_018']; ?></p>
                </div>
            </div>
            <a href="/<?php echo $nyelv; ?>/gallery#smallThings" class="button button-secondary"><?php echo $FORDITASOK['all_smallThings']; ?></a>
        </section>        
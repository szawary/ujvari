<?php 
// Az index.php beállította a $nyelv, $keresett_oldal és $FORDITASOK változókat!
global $nyelv, $keresett_oldal, $FORDITASOK;
?>
<!DOCTYPE html>
<html lang="<?php echo $nyelv; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $FORDITASOK['oldal_cim_' . $keresett_oldal]; ?></title>
    
    <?php
        $ALAP_DOMAIN = "https://az-on-domain-neve.hu";
        $kanonikus_url = $ALAP_DOMAIN . '/' . $nyelv . '/' . $keresett_oldal;

        $meta_leirasok = [
            'home' => $FORDITASOK['meta_description_home'] ?? null,
            'gallery' => $FORDITASOK['meta_description_gallery'] ?? null,
        ];
        $meta_description = $meta_leirasok[$keresett_oldal] ?? null;
    ?>

    <link rel="canonical" href="<?php echo $kanonikus_url; ?>" />
    <link rel="alternate" href="<?php echo $ALAP_DOMAIN; ?>/hu/<?php echo $keresett_oldal; ?>" hreflang="hu" />
    <link rel="alternate" href="<?php echo $ALAP_DOMAIN; ?>/de/<?php echo $keresett_oldal; ?>" hreflang="de" />
    <link rel="alternate" href="<?php echo $ALAP_DOMAIN; ?>/en/<?php echo $keresett_oldal; ?>" hreflang="en" />
    <link rel="alternate" href="<?php echo $ALAP_DOMAIN; ?>/en/<?php echo $keresett_oldal; ?>" hreflang="x-default" />

    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

    <?php if (!empty($meta_description)) : ?>
        <meta name="description" content="<?php echo htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="og:title" content="<?php echo htmlspecialchars($FORDITASOK['oldal_cim_' . $keresett_oldal], ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="og:description" content="<?php echo htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo $kanonikus_url; ?>">
        <meta property="og:image" content="<?php echo $ALAP_DOMAIN; ?>/images/profil.jpg">
    <?php endif; ?>

    <link rel="stylesheet" href="/assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>

    <header class="main-header">
        <div class="logo">
            <h1><a href="/<?php echo $nyelv; ?>/home" style="text-decoration: none; color: inherit;"><?php echo $FORDITASOK['logo_cim']; ?></a></h1>
        </div>
        
        <nav class="language-selector">
            <?php 
            // Az aktuális oldal URL-címe kell, hogy megmaradjon váltáskor
            $aktualis_oldal = $keresett_oldal; 
            ?>
            <a href="/hu/<?php echo $aktualis_oldal; ?>" <?php if ($nyelv == 'hu') echo 'class="active"'; ?>>HU</a>
            <span class="separator">|</span>
            <a href="/de/<?php echo $aktualis_oldal; ?>" <?php if ($nyelv == 'de') echo 'class="active"'; ?>>DE</a>
            <span class="separator">|</span>
            <a href="/en/<?php echo $aktualis_oldal; ?>" <?php if ($nyelv == 'en') echo 'class="active"'; ?>>EN</a>
        </nav>
        
        <nav class="main-nav" aria-label="Fő navigáció">
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu-list">
                <span class="menu-icon" aria-hidden="true"></span>
                <span class="menu-label">Menü</span>
            </button>
            <ul id="primary-menu-list">
            <?php
            // DEFINIÁLJUK A MENÜPONTOK STRUKTÚRÁJÁT ÉS ANCHOR ID-IT
            // A 'section_title_XX' stringek a hu.php-ban deklarált kulcsokra hivatkoznak.
            $category_items = [
                // [Fordítás Kulcs, Anchor ID]
                ['section_title_02', '#sets'],
                ['section_title_03', '#earrings'],
                ['section_title_04', '#bracelets'],
                ['section_title_05', '#rings'],
                ['section_title_06', '#smallThings'],
            ];
            
            // A céloldal mindig az aktuális oldal lesz (home vagy gallery),
            // ami megakadályozza a galériából való "visszaugrást" a főoldalra.
            $target_page = $keresett_oldal;
            
            foreach ($category_items as $item) : 
                $title_key = $item[0];
                $anchor_id = $item[1];
                
                // Link összeállítása: /nyelv/aktuális_oldal#anchorID
                $link_url = '/' . $nyelv . '/' . $target_page . $anchor_id;
            ?>
                <li>
                    <a href="<?php echo $link_url; ?>">
                        <?php echo $FORDITASOK[$title_key]; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </nav>
    </header>

    <main>
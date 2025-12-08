<?php
// Munkamenet indítása (fontos a nyelv eltárolásához)
session_start();

// --- Konfiguráció ---
$TÁMOGATOTT_NYELVEK = ['hu', 'de', 'en'];
$ALAPÉRTELMEZETT_NYELV = 'en';

// --- 1. Nyelvkód meghatározása (Prioritási sorrend) ---

$nyelv = $ALAPÉRTELMEZETT_NYELV;

// 1.1. Felülbírálás GET paraméterrel (pl. ha a felhasználó rákattint egy nyelvi linkre)
if (isset($_GET['lang']) && in_array($_GET['lang'], $TÁMOGATOTT_NYELVEK)) {
    $nyelv = $_GET['lang'];
    $_SESSION['lang'] = $nyelv; // Eltárolás a munkamenetben
} 
// 1.2. Visszaállítás a Session-ből (ha már járt itt)
elseif (isset($_SESSION['lang'])) {
    $nyelv = $_SESSION['lang'];
}
// 1.3. Automatikus felismerés a böngésző Accept-Language fejlécéből (Csak első alkalommal)
else {
    $preferalt_nyelvek = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
    
    // Német (de) az első (Német nyelvterületre)
    if (strpos($preferalt_nyelvek, 'de') !== false) {
        $nyelv = 'de';
    } 
    // Magyar (hu) a második (Magyarországról)
    elseif (strpos($preferalt_nyelvek, 'hu') !== false) {
        $nyelv = 'hu';
    }
    // Egyébként az alapértelmezett 'en' marad

    $_SESSION['lang'] = $nyelv; 
}

// --- 2. Tartalom beolvasása (Lokalizáció) ---

// A kiválasztott nyelvi fájl betöltése (ez állítja be a $FORDITASOK tömböt)
$nyelvi_fajl_utvonal = "lang/{$nyelv}.php";
if (!file_exists($nyelvi_fajl_utvonal)) {
    // Ha hiányzik a fordítás (pl. hibás a nyelvkód), visszaállás az alapértelmezettre
    $nyelv = $ALAPÉRTELMEZETT_NYELV;
    $nyelvi_fajl_utvonal = "lang/{$nyelv}.php";
}
$FORDITASOK = require_once($nyelvi_fajl_utvonal);

// --- 3. Átirányítás és Oldal Betöltése ---

// A lekérdezett oldal neve (alapértelmezett: home)
$keresett_oldal = $_GET['page'] ?? 'home'; 

// Átirányítás: Ha a felismert nyelv nem egyezik az URL-ben lévő nyelvvel, átirányítjuk
if (!isset($_GET['lang']) || $_GET['lang'] !== $nyelv) {
    // 302-es átirányítás a korrekt, nyelvkódot tartalmazó URL-re
    header("Location: /{$nyelv}/{$keresett_oldal}", true, 302);
    exit();
}

// --- 4. Az oldal betöltése ---

$oldal_fajl = "pages/{$keresett_oldal}.php";
if (file_exists($oldal_fajl)) {
    // Betöltjük a kereteket és a tartalmat
    require_once("includes/header.php");
    require_once($oldal_fajl); 
    require_once("includes/footer.php");
} else {
    // 404-es hiba
    http_response_code(404);
    echo "<h1>404 Hiba!</h1><p>A keresett oldal ({$keresett_oldal}) nem található. Kérjük, térjen vissza a <a href=\"/{$nyelv}/home\">főoldalra</a>.</p>";
}
?>


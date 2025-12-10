<?php
// Munkamenet indítása (fontos a nyelv eltárolásához)
session_start();

// --- Konfiguráció ---
$TÁMOGATOTT_NYELVEK = ['hu', 'de', 'en'];
$ALAPÉRTELMEZETT_NYELV = 'en';

// --- 1. Nyelvkód meghatározása (Prioritási sorrend) ---

$nyelv = $ALAPÉRTELMEZETT_NYELV;

/**
 * A böngésző Accept-Language fejlécéből választja ki a támogatott nyelvet
 * a q értékek és a megjelenési sorrend figyelembevételével.
 */
function valassz_nyelvet_fejlecbol(string $fejlec, array $tamogatott_nyelvek, string $alapertelmezett): string
{
    $preferenciak = [];
    $reszek = array_filter(array_map('trim', explode(',', $fejlec)));

    foreach ($reszek as $index => $elem) {
        $lang_reszek = explode(';', $elem);
        $nyelvkod = strtolower(trim($lang_reszek[0] ?? ''));

        if (empty($nyelvkod)) {
            continue;
        }

        // Csak az elsődleges kódra van szükség (hu-HU -> hu)
        $nyelvkod = substr($nyelvkod, 0, 2);

        $q = 1.0;
        if (isset($lang_reszek[1]) && preg_match('/q=([0-9.]+)/', $lang_reszek[1], $egyezes)) {
            $q = (float) $egyezes[1];
        }

        $preferenciak[] = [
            'kod' => $nyelvkod,
            'q' => $q,
            'index' => $index,
        ];
    }

    usort($preferenciak, function ($a, $b) {
        if ($a['q'] === $b['q']) {
            return $a['index'] <=> $b['index'];
        }
        return $b['q'] <=> $a['q'];
    });

    foreach ($preferenciak as $preferencia) {
        if (in_array($preferencia['kod'], $tamogatott_nyelvek)) {
            return $preferencia['kod'];
        }
    }

    return $alapertelmezett;
}

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

    if (!empty($preferalt_nyelvek)) {
        $nyelv = valassz_nyelvet_fejlecbol($preferalt_nyelvek, $TÁMOGATOTT_NYELVEK, $ALAPÉRTELMEZETT_NYELV);
    }

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


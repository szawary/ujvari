<?php
/**
 * Sitemap generator for agnesujvari.com.
 *
 * Scans public PHP pages and images to build a Google-compliant sitemap.
 */

$baseUrl = 'https://agnesujvari.com';
$webRoot = __DIR__;
$outputFile = $webRoot . '/sitemap.xml';

// List of image file extensions to include in the image sitemap.
$imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];

/**
 * Normalize the relative path of a file based on the web root.
 */
function buildUrl(string $baseUrl, string $webRoot, string $filePath): string
{
    $relativePath = ltrim(str_replace($webRoot, '', $filePath), DIRECTORY_SEPARATOR);
    return rtrim($baseUrl, '/') . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
}

/**
 * Collect PHP files directly under the web root, excluding specific directories.
 *
 * @return array<int, string>
 */
function collectRootPhpFiles(string $webRoot): array
{
    $files = [];
    foreach (glob($webRoot . '/*.php') as $file) {
        if (is_file($file)) {
            $files[] = $file;
        }
    }

    return $files;
}

/**
 * Recursively collect PHP files from a directory.
 *
 * @return array<int, string>
 */
function collectPhpFiles(string $directory): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isFile() && strtolower($fileInfo->getExtension()) === 'php') {
            $files[] = $fileInfo->getPathname();
        }
    }

    return $files;
}

/**
 * Recursively collect image files using the allowed extensions.
 *
 * @return array<int, string>
 */
function collectImages(string $directory, array $extensions): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $fileInfo) {
        if (!$fileInfo->isFile()) {
            continue;
        }

        $extension = strtolower($fileInfo->getExtension());
        if (in_array($extension, $extensions, true)) {
            $files[] = $fileInfo->getPathname();
        }
    }

    return $files;
}

/**
 * Create a sitemap entry array.
 */
function createEntry(string $url, int $lastModified, array $images = []): array
{
    return [
        'loc' => $url,
        'lastmod' => gmdate('c', $lastModified),
        'changefreq' => 'weekly',
        'priority' => '0.8',
        'images' => $images,
    ];
}

// Collect PHP pages from the web root.
$urls = [];
foreach (collectRootPhpFiles($webRoot) as $phpFile) {
    $urls[] = createEntry(
        buildUrl($baseUrl, $webRoot, $phpFile),
        filemtime($phpFile)
    );
}

// Collect PHP pages from /pages/.
$pagesDir = $webRoot . '/pages';
if (is_dir($pagesDir)) {
    foreach (collectPhpFiles($pagesDir) as $phpFile) {
        $urls[] = createEntry(
            buildUrl($baseUrl, $webRoot, $phpFile),
            filemtime($phpFile)
        );
    }
}

// Collect images and include them as image sitemap entries.
$imagesDir = $webRoot . '/images';
if (is_dir($imagesDir)) {
    foreach (collectImages($imagesDir, $imageExtensions) as $imageFile) {
        $imageUrl = buildUrl($baseUrl, $webRoot, $imageFile);
        $urls[] = createEntry(
            $imageUrl,
            filemtime($imageFile),
            [$imageUrl]
        );
    }
}

// Generate the XML sitemap using DOMDocument for readability and correctness.
$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;

$urlset = $dom->createElement('urlset');
$urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$urlset->setAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');

foreach ($urls as $entry) {
    $urlElement = $dom->createElement('url');

    $loc = $dom->createElement('loc', htmlspecialchars($entry['loc'], ENT_XML1));
    $urlElement->appendChild($loc);

    $lastmod = $dom->createElement('lastmod', $entry['lastmod']);
    $urlElement->appendChild($lastmod);

    $changefreq = $dom->createElement('changefreq', $entry['changefreq']);
    $urlElement->appendChild($changefreq);

    $priority = $dom->createElement('priority', $entry['priority']);
    $urlElement->appendChild($priority);

    foreach ($entry['images'] as $imageUrl) {
        $imageElement = $dom->createElement('image:image');
        $imageLoc = $dom->createElement('image:loc', htmlspecialchars($imageUrl, ENT_XML1));
        $imageElement->appendChild($imageLoc);
        $urlElement->appendChild($imageElement);
    }

    $urlset->appendChild($urlElement);
}

$dom->appendChild($urlset);

if ($dom->save($outputFile) === false) {
    fwrite(STDERR, "Failed to write sitemap.xml\n");
    exit(1);
}

echo "Sitemap generated at {$outputFile}\n";

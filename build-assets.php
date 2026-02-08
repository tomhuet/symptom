#!/usr/bin/env php
<?php
/**
 * Simple asset minifier for CSS and JS files
 * Run: php build-assets.php
 */

function minifyCSS($css) {
    // Remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // Remove whitespace
    $css = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $css);
    $css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $css);
    $css = preg_replace('/;}/', '}', $css);
    return trim($css);
}

function minifyJS($js) {
    // Remove single line comments (careful with URLs)
    $js = preg_replace('~//[^\n]*~', '', $js);
    // Remove multi-line comments
    $js = preg_replace('~/\*.*?\*/~s', '', $js);
    // Remove extra whitespace
    $js = preg_replace('/\s+/', ' ', $js);
    // Remove whitespace around operators
    $js = preg_replace('/\s*([=+\-*\/<>!&|,;:(){}[\]])\s*/', '$1', $js);
    return trim($js);
}

echo "Building minified assets...\n\n";

// Minify CSS files
$cssFiles = ['assets/css/styles.css', 'assets/css/project.css'];
foreach ($cssFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $minified = minifyCSS($content);
        $minFile = str_replace('.css', '.min.css', $file);
        file_put_contents($minFile, $minified);
        
        $original = strlen($content);
        $min = strlen($minified);
        $saved = round(($original - $min) / $original * 100, 1);
        
        echo "✓ {$file} → {$minFile}\n";
        echo "  Original: " . number_format($original) . " bytes\n";
        echo "  Minified: " . number_format($min) . " bytes\n";
        echo "  Saved: {$saved}%\n\n";
    }
}

// Minify JS files
$jsFiles = ['assets/js/script.js'];
foreach ($jsFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $minified = minifyJS($content);
        $minFile = str_replace('.js', '.min.js', $file);
        file_put_contents($minFile, $minified);
        
        $original = strlen($content);
        $min = strlen($minified);
        $saved = round(($original - $min) / $original * 100, 1);
        
        echo "✓ {$file} → {$minFile}\n";
        echo "  Original: " . number_format($original) . " bytes\n";
        echo "  Minified: " . number_format($min) . " bytes\n";
        echo "  Saved: {$saved}%\n\n";
    }
}

echo "✓ Build complete!\n";
echo "\nTo use minified files in production, update your HTML files to reference .min.css and .min.js files.\n";

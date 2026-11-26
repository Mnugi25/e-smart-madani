<?php
$file = 'c:\\Web Sekolah\\presensi\\resources\\views\\landpage.blade.php';
$content = file_get_contents($file);

// Replace Hex values (case insensitive)
$replacements = [
    '#4f46e5' => '#1e3a8a',
    '#4F46E5' => '#1e3a8a',
    '79, 70, 229' => '30, 58, 138', // RGB for #1e3a8a (approx)
    
    '#6366f1' => '#1e40af',
    '#6366F1' => '#1e40af',
    '99, 102, 241' => '30, 64, 175', // RGB for #1e40af
    
    '#818cf8' => '#3b82f6',
    '#818CF8' => '#3b82f6',
    '129, 140, 248' => '59, 130, 246', // RGB for #3b82f6
];

foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

file_put_contents($file, $content);
echo "Successfully updated landpage colors!\n";
?>

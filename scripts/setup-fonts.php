<?php

$fontsDir = __DIR__ . '/../public/fonts';
if (!is_dir($fontsDir)) {
    mkdir($fontsDir, 0755, true);
}

// Font files to download
$fonts = [
    'Montserrat-Regular.ttf' => 'https://github.com/JulietaUla/Montserrat/raw/master/fonts/ttf/Montserrat-Regular.ttf',
    'Montserrat-Bold.ttf' => 'https://github.com/JulietaUla/Montserrat/raw/master/fonts/ttf/Montserrat-Bold.ttf',
    'fa-solid-900.ttf' => 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/webfonts/fa-solid-900.ttf',
    'fa-brands-400.ttf' => 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/webfonts/fa-brands-400.ttf'
];

echo "Downloading required fonts...\n";

foreach ($fonts as $filename => $url) {
    $destination = $fontsDir . '/' . $filename;
    
    if (!file_exists($destination)) {        echo "Downloading {$filename}...\n";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        
        $content = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($content === false || $httpCode !== 200) {
            echo "Error downloading {$filename} (HTTP {$httpCode})\n";
            continue;
        }
        
        file_put_contents($destination, $content);
        echo "Successfully downloaded {$filename}\n";
    } else {
        echo "{$filename} already exists\n";
    }
}

echo "Font setup completed!\n";

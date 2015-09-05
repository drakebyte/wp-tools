<?php

add_usage('download-wp',
          '',
          "Downloads the site content from the content server specified by 'contentServer' in the wpconfig.json. The full URL to be downloaded is 'contentServer'/'id'.tgz" . PHP_EOL .
          PHP_EOL .
          "Example: http://wpcontentdeva.cloud.mywebgrocer.com/celebration.com.tgz");

function command_download_wp() {
    global $argc, $argv;
    
    $config = parse_config();
    if ($config === FALSE) {
        exit;
    }
    
    if (!command_exists('wp')) {
        fwrite(STDERR, "Cannot find wp command, add it to your path and try again\r\n");
        exit;
    }
    
    $cmd = "wp core download " . (isset($config['version']) ? "--version={$config['version']}" : "");
    $out = shell_exec($cmd);
    fwrite(STDOUT, $out);
}
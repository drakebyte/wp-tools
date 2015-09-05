<?php

add_usage('--info',
          '',
          'Displays all relevant versions and if the wpconfig.json file is present and valid');

function command_info() {
    
    if (!command_exists('wp')) {
        fwrite(STDERR, "Cannot find wp command, add it to your path and try again\r\n");
        exit;
    }

    $cmd = "wp --info";
    $out = shell_exec($cmd);
    fwrite(STDOUT, $out);
    
    fwrite(STDOUT, "WP-Tools version: " . WP_TOOLS_VERSION_MAJOR . "." . WP_TOOLS_VERSION_MINOR . "\r\n");
    
    $filename = str_replace('\\', '/', getcwd()) . '/wpconfig.json';
    if (!file_exists($filename)) {
        fwrite(STDOUT, "wpconfig.json not present\r\n");
    } else {
        $config = parse_config();
        if ($config === false) {
            fwrite(STDOUT, "wpconfig.json not valid\r\n");
        } else {
            fwrite(STDOUT, "wpconfig.json present and valid\r\n");
        }
    }
    
}
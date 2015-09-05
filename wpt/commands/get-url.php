<?php

add_usage('get-url',
          'URL',
          "Outputs the url from the config file with the given ID." . PHP_EOL .
          PHP_EOL .
          "Example: wptools get-url prod" . PHP_EOL .
          "www.celebrations.com");

function command_get_url() {
    global $argc, $argv;
    
    $config = parse_config();
    
    if ($argc < 3) {
        fwrite(STDERR, "Not enough arguments specified\r\n");
        usage('get-url');
        exit;
    }
    
    $url = $argv[2];
    
    if (!isset($config['id']) ||
        !isset($config['urls']) ||
        !isset($config['urls'][$url])) {
        fwrite(STDERR, "Incomplete config, please enter all required fields\r\n");
        exit;
    }
    
    echo $config['urls'][$url];
}
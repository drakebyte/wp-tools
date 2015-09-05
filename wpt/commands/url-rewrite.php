<?php

add_usage('url-rewrite',
          'FROM_URL TO_URL',
          "Performs a search-and-replace on the database with the given URLs. The URLs will be pulled from the 'urls' section of the wpconfig.json file" . PHP_EOL .
          PHP_EOL .
          "Example: wptools url-rewrite prod local" . PHP_EOL .
          "This will rewrite all production URLs in the database and replace them with the local URLs as they are defined in the wpconfig.json");

function command_url_rewrite() {
    global $argc, $argv;
    
    if ($argc < 4) {
        fwrite(STDERR, "Not enough arguments specified\r\n");
        usage('url-rewrite');
        exit;
    }
    
    if (!command_exists('wp')) {
        fwrite(STDERR, "Cannot find wp command, add it to your path and try again\r\n");
        exit;
    }
    
    $url_search = $argv[2];
    $url_replace = $argv[3];
    
    $config = parse_config();
    if ($config === FALSE) {
        exit;
    }
    
    if (!isset($config['urls']) ||
        !isset($config['urls'][$url_search]) ||
        !isset($config['urls'][$url_replace])) {
        fwrite(STDERR, "Incomplete config, please enter all required fields\r\n");
        fwrite(STDERR, "  {urls:$url_search}, {urls:$url_replace}\r\n");
        exit;
    }
    
    $cmd = "wp search-replace \"{$config['urls'][$url_search]}\" \"{$config['urls'][$url_replace]}\"";
    $out = shell_exec($cmd);
    fwrite(STDOUT, $out);
}
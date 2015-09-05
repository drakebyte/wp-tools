<?php

add_usage('create-wp-config',
          '',
          "Uses the options in wpconfig.json to create a wp-config.php file using the 'wp' command.");

function command_create_wp_config() {
    global $argc, $argv;
    
    $config = parse_config();
    if ($config === FALSE) {
        exit;
    }
    
    if (!command_exists('wp')) {
        fwrite(STDERR, "Cannot find wp command, add it to your path and try again\r\n");
        exit;
    }
    
    if (!isset($config['db']) ||
        !isset($config['db']['name']) ||
        !isset($config['db']['user']) ||
        !isset($config['db']['pass'])) {
        fwrite(STDERR, "Incomplete config, please enter all required fields\r\n");
        fwrite(STDERR, "  {db:name}, {db:user}, {db:pass}\r\n");
        exit;
    }
    
    if (!isset($config['db']['host'])) {
        $config['db']['host'] = 'localhost';
    }
    
    $cmd = "wp core config " .
           "--dbname=\"{$config['db']['name']}\" " .
           "--dbuser=\"{$config['db']['user']}\" " .
           "--dbpass=\"{$config['db']['pass']}\" " .
           "--dbhost=\"{$config['db']['host']}\" ";
    $out = shell_exec($cmd);
    fwrite(STDOUT, $out);
}
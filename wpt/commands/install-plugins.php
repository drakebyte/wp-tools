<?php

add_usage('install-plugins',
          '',
          "Installs the plugins outlined in wpconfig.json with the versions specified, and activates them.");

function command_install_plugins() {
    global $argc, $argv;
    
    $config = parse_config();
    if ($config === FALSE) {
        exit;
    }
    
    if (!command_exists('wp')) {
        fwrite(STDERR, "Cannot find wp command, add it to your path and try again\r\n");
        exit;
    }
    
    if (!isset($config['plugins']) ||
        empty($config['plugins'])) {
        fwrite(STDERR, "Incomplete config, please enter all required fields\r\n");
        fwrite(STDERR, "  {plugins}\r\n");
        exit;
    }
    
    foreach ($config['plugins'] as $name => $ver) {
        $out = shell_exec("wp plugin install $name --activate --version=$ver");
        fwrite(STDOUT, $out . "\r\n");
    }
}
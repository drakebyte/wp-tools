<?php

add_usage('install',
          'URL',
          "Installs a new wordpress site to using 'wp core install' and the options in wpconfig.json");

function command_install() {
    global $argc, $argv;
    
    $config = parse_config();
    if ($config === FALSE) {
        exit;
    }
    
    if ($argc < 3) {
        fwrite(STDERR, "Not enough arguments specified\r\n");
        usage('install');
        exit;
    }
    
    $url = $argv[2];
    
    if (!command_exists('wp')) {
        fwrite(STDERR, "Cannot find wp command, add it to your path and try again\r\n");
        exit;
    }
    
    if (!isset($config['id']) ||
        !isset($config['name']) ||
        !isset($config['adminUser']) ||
        !isset($config['adminEmail']) ||
        !isset($config['urls']) ||
        !isset($config['urls'][$url])) {
        fwrite(STDERR, "Incomplete config, please enter all required fields\r\n");
        fwrite(STDERR, "  {id}, {name}, {adminUser}, {adminEmail}, {urls}, {urls:$url}\r\n");
        exit;
    }
    
    $generated_pass = false;
    if (!isset($config['adminPass'])) {
        $config['adminPass'] = random_password();
        $generated_pass = true;
    }
    
    $cmd = "wp core install " .
           "--url=\"http://{$config['urls'][$url]}/\" " .
           "--title=\"{$config['name']}\" " .
           "--admin_user=\"{$config['adminUser']}\" " .
           "--admin_password=\"{$config['adminPass']}\" " .
           "--admin_email=\"{$config['adminEmail']}\" ";
    $out = shell_exec($cmd);
    fwrite(STDOUT, $out);
    
    $cmd = "wp search-replace \"{$config['urls'][$url]}/vhosts/{$config['id']}\" \"{$config['urls'][$url]}\"";
    $out = shell_exec($cmd);
    fwrite(STDOUT, $out);
    
    if ($generated_pass) {
        fwrite(STDOUT, "Generated Admin Password: {$config['adminPass']}\r\n");
    }
}
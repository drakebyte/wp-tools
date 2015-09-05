<?php

add_usage('create-vhost-entry',
          'CONF_DIR',
          "Saves a file named [website]-vhost.conf in the given CONF_DIR with an apache <VirtualServer> directive within it." . PHP_EOL .
          PHP_EOL .
          "Note: CONF_DIR will usually be /etc/httpd/conf.d/ on CentOS Linux and C:/xampp/apache/conf.d/ on Windows");

function command_create_vhost_entry() {
    global $argc, $argv;
    
    $config = parse_config();
    
    if ($argc < 3) {
        fwrite(STDERR, "Not enough arguments specified\r\n");
        usage();
        exit;
    }
    
    $conf_dir = $argv[2];
    if (!is_dir($conf_dir)) {
        fwrite(STDERR, "Invalid CONF_DIR specified\r\n");
        exit;
    }
    
    $conf_dir = str_replace('\\', '/', $conf_dir);
    $conf_dir = rtrim($conf_dir, '/');

    if (!isset($config['id']) ||
        !isset($config['urls']) ||
        !isset($config['urls']['prod'])) {
        fwrite(STDERR, "Incomplete config, please enter all required fields\r\n");
        fwrite(STDERR, "  {id}, {urls:prod}\r\n");
        exit;
    }
    
    $vhost = 
"<VirtualHost *:80>
  DocumentRoot \"C:/xampp/vhosts/{$config['id']}/\"
  ServerName {$config['urls']['prod']}";
  
    foreach ($config['urls'] as $name => $url) {
        if ($name == 'prod') continue;
        $vhost .= "\n  ServerAlias $url";
    }
    
    $vhost .= "
  ErrorLog \"logs/{$config['id']}.log\"
  CustomLog \"logs/{$config['id']}-access.log\" common
</VirtualHost>";

    $filename = "{$conf_dir}/{$config['id']}-vhost.conf";
    $ret = file_put_contents($filename, $vhost);
    
    if ($ret !== FALSE) {
        fwrite(STDOUT, "Created {$filename}\r\n");
    } else {
        fwrite(STDERR, "Cannot create {$filename}\r\n");
    }
}
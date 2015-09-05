<?php

add_usage('update-plugin-list',
          '',
          "Updates wpconfig.json with the current list of active plugins and their versions.");

function command_update_plugin_list() {
    global $argc, $argv;
    
    $config = parse_config();
    if ($config === FALSE) {
        exit;
    }
    
    $config['plugins'] = array();
    
    $out = shell_exec("wp plugin list --status=active --format=json");
    $plugins = json_decode($out, true);
    
    foreach ($plugins as $plugin) {
        $config['plugins'][$plugin['name']] = $plugin['version'];
    }
    
    $ret = save_config($config);
    if ($ret !== FALSE) {
        fwrite(STDOUT, "Updated wpconfig.json with active plugins and versions\r\n");
    } else {
        fwrite(STDERR, "Failed to update wpconfig.json\r\n");
    }
}
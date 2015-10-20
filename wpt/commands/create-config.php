<?php

add_usage('create-config',
          '',
          "Save a blank wpconfig.json file in the current directory with the minimum set of options needed.");

function command_create_config() {
    global $argc, $argv;
    
    $config = array(
        'name' => 'Website',
        'id' => 'website.com',
        'adminUser' => 'site_admin',
        'adminEmail' => 'admin@website.com',
        'urls' => array(
            'local' => 'website.local',
            'dev' => 'dev.website.com',
            'qa' => 'qa.website.com',
            'uat' => 'uat.website.com',
            'prod' => 'www.website.com',
        ),
        'db' => array(
            'name' => 'website_db',
            'user' => 'website_usr',
            'host' => 'localhost',
        ),
        'plugins' => array(
            'akismet' => '3.1.3',
        ),
    );
    
    save_config($config);
}
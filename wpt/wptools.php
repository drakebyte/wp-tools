<?php

if (PHP_SAPI !== 'cli') die();

define('WP_TOOLS_VERSION_MAJOR', 1);
define('WP_TOOLS_VERSION_MINOR', 7);

require_once 'functions.php';
require_once 'usage.php';
require_once 'commands/info.php';
require_once 'commands/create-config.php';
require_once 'commands/create-vhost-entry.php';
require_once 'commands/create-wp-config.php';
require_once 'commands/create-db.php';
require_once 'commands/download-wp.php';
require_once 'commands/download-content.php';
require_once 'commands/install.php';
require_once 'commands/install-plugins.php';
require_once 'commands/update-plugin-list.php';
require_once 'commands/get-url.php';
require_once 'commands/url-rewrite.php';

if ($argc == 1) {
    usage();
    exit;
}

$commands = array(
    '--info'                => 'command_info',
    'create-config'         => 'command_create_config',
    'create-vhost-entry'    => 'command_create_vhost_entry',
    'create-wp-config'      => 'command_create_wp_config',
    'create-db'             => 'command_create_db',
    'download-wp'           => 'command_download_wp',
    'download-content'      => 'command_download_content',
    'install'               => 'command_install',
    'install-plugins'       => 'command_install_plugins',
    'update-plugin-list'    => 'command_update_plugin_list',
    'get-url'               => 'command_get_url',
    'url-rewrite'           => 'command_url_rewrite',
);
$subcommand = $argv[1];
if (isset($commands[$subcommand]) && is_callable($commands[$subcommand])) {
    $commands[$subcommand]();
} else {
    fwrite(STDOUT, "Unknown Command '{$subcommand}'\r\n");
    usage();
}
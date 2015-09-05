<?php

$phar = new Phar('wp-tools.phar',
                 FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
                 'wp-tools.phar');

$phar['wptools.php']                        = file_get_contents('wptools.php');
$phar['functions.php']                      = file_get_contents('functions.php');
$phar['usage.php']                          = file_get_contents('usage.php');
$phar['commands/info.php']                  = file_get_contents('commands/info.php');
$phar['commands/create-config.php']         = file_get_contents('commands/create-config.php');
$phar['commands/create-vhost-entry.php']    = file_get_contents('commands/create-vhost-entry.php');
$phar['commands/create-wp-config.php']      = file_get_contents('commands/create-wp-config.php');
$phar['commands/create-db.php']             = file_get_contents('commands/create-db.php');
$phar['commands/download-wp.php']           = file_get_contents('commands/download-wp.php');
$phar['commands/download-content.php']      = file_get_contents('commands/download-content.php');
$phar['commands/install.php']               = file_get_contents('commands/install.php');
$phar['commands/install-plugins.php']       = file_get_contents('commands/install-plugins.php');
$phar['commands/update-plugin-list.php']    = file_get_contents('commands/update-plugin-list.php');
$phar['commands/get-url.php']               = file_get_contents('commands/get-url.php');
$phar['commands/url-rewrite.php']           = file_get_contents('commands/url-rewrite.php');

$phar->setStub("#!/usr/bin/php \n" . $phar->createDefaultStub('wptools.php'));

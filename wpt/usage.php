<?php

$usage_statements = array();
function add_usage($cmd, $args, $info) {
    global $usage_statements;
    $usage_statements[$cmd] = array(
        'args' => $args,
        'info' => $info,
    );
}

function usage( $command = '' ) {
    global $usage_statements;
    
    if (!empty($command) && isset($usage_statements[$command])) {
        $usage = $usage_statements[$command];
        echo PHP_EOL;
        command_usage($command, $usage['args'], $usage['info']);
        return;
    }
    
    $main_usage =
"Usage: wpt [SUBCMD] [OPTIONS]
Runs a set of useful tools for wordpress development.

Note: This tool requires the 'wp' and 'mysql' commands to be installed as well.
Note: Most subcommands require a configuration file named wpconfig.json in order to run. Please run this command in the same directory as this file.

This command can run all the same commands as the 'wp' command

WP Tools Specific Subcommands:

";

    echo wordwrap($main_usage, 80, PHP_EOL);

    foreach ($usage_statements as $cmd => $usage) {
        command_usage($cmd, $usage['args'], $usage['info']);
    }
}

function command_usage($cmd, $args, $info) {
    $tab = "    ";
    echo $tab . $cmd . ' ' . $args . PHP_EOL;
    
    $info = wordwrap($info, 72, PHP_EOL);
    $lines = explode(PHP_EOL, $info);
    foreach ($lines as $line) {
        echo $tab . $tab . $line . PHP_EOL;
    }
    echo PHP_EOL;
}
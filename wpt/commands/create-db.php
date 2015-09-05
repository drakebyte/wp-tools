<?php

add_usage('create-db',
          '[MYSQL_USER] [MYSQL_PASS]',
          "Uses the options in wpconfig.json to create a database and user by calling the mysql command." . PHP_EOL .
          PHP_EOL .
          "Note: [MYSQL_USER] and [MYSQL_PASS] are not required, but may need to be set to allow the tool to create the database.");

function command_create_db() {
    global $argc, $argv;
    
    $config = parse_config();
    if ($config === FALSE) {
        exit;
    }
    
    if (!command_exists('mysql')) {
        fwrite(STDERR, "Cannot find mysql command, add it to your path and try again\r\n");
        exit;
    }
    
    if (!isset($config['db']) ||
        !isset($config['db']['name']) ||
        !isset($config['db']['user'])) {
        fwrite(STDERR, "Incomplete config, please enter all required fields:\r\n");
        fwrite(STDERR, "  {db:name}, {db:user}\r\n");
        exit;
    }
    
    if (!isset($config['db']['host'])) {
        $config['db']['host'] = 'localhost';
    }
    
    $generated_pass = false;
    if (!isset($config['db']['pass'])) {
        $config['db']['pass'] = random_password();
        $generated_pass = true;
    }
    
    $create_db_sql = "CREATE DATABASE IF NOT EXISTS `{$config['db']['name']}`;";
    $create_user_sql =
        "GRANT ALL ON `{$config['db']['name']}`.* " .
        "TO '{$config['db']['user']}'@'{$config['db']['host']}' " .
        "IDENTIFIED BY '{$config['db']['pass']}' " .
        "WITH GRANT OPTION;";
    
    if ($generated_pass) {
        fwrite(STDOUT, "Generated Password for Database: {$config['db']['pass']}\r\n");
        $ret = save_config($config);
        if ($ret !== FALSE) {
            fwrite(STDOUT, "Updated wpconfig.json with generated password\r\n");
        } else {
            fwrite(STDERR, "Failed to update wpconfig.json with generated password\r\n");
        }
    }
    
    $mysql_opts = '';
    if ($argc >= 3) { // MYSQL_USER
        $mysql_opts .= " -u {$argv[2]} ";
    }
    
    if ($argc >= 4) { // MYSQL_PASS
        $mysql_opts .= " -p {$argv[2]} ";
    }
    
    fwrite(STDOUT, "Running Create Database command\r\n");
    $out = shell_exec("mysql {$mysql_opts} -e \"{$create_db_sql}\"");
    if ($out !== NULL) {
        fwrite(STDERR, "Failed to run Create Database command\r\n");
        exit;
    }
    
    fwrite(STDOUT, "Running Create User command\r\n");
    $out = shell_exec("mysql {$mysql_opts} -e \"{$create_user_sql}\"");
    if ($out !== NULL) {
        fwrite(STDERR, "Failed to run Create User command\r\n");
        exit;
    }
}
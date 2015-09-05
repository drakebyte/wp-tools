<?php 

if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

function parse_config( $filename = 'wpconfig.json' ) {
    $filename = str_replace('\\', '/', getcwd()) . '/' . $filename;
    if (!file_exists($filename)) {
        fwrite(STDERR, "File wpconfig.json does not exist\r\n");
        return FALSE;
    }
    $json = file_get_contents($filename);
    if ($json === FALSE || strlen(trim($json)) === 0) {
        fwrite(STDERR, "Cannot open wpconfig.json\r\n");
    }
    $config = json_decode($json, true);
    if ($config !== FALSE) {
        return $config;
    } else {
        fwrite(STDERR, "Unable to parse wpconfig.json\r\n");
        return FALSE;
    }
}

function save_config( $config, $filename = 'wpconfig.json' ) {
    if (PHP_VERSION_ID < 50400) {
        $json = json_encode($config);
    } else {
        $json = json_encode($config, JSON_PRETTY_PRINT);
    }
    
    $filename = str_replace('\\', '/', getcwd()) . '/' . $filename;
    $ret = file_put_contents($filename, $json);
    
    if ($ret !== FALSE) {
        fwrite(STDOUT, "Saved {$filename}\r\n");
        return TRUE;
    } else {
        fwrite(STDERR, "Cannot save {$filename}\r\n");
        return FALSE;
    }
}

function random_password($len = 20) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
    $pass = '';
    for ($i = 0; $i < $len; ++$i) {
        $r = rand(0, strlen($chars) - 1);
        $pass .= $chars[$r];
    }
    return $pass;
}

function command_exists($command) {
  $whereIsCommand = (PHP_OS == 'WINNT') ? 'where' : 'which';

  $process = proc_open(
    "$whereIsCommand $command",
    array(
      0 => array("pipe", "r"), //STDIN
      1 => array("pipe", "w"), //STDOUT
      2 => array("pipe", "w"), //STDERR
    ),
    $pipes
  );
  if ($process !== false) {
    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($process);

    return $stdout != '';
  }

  return false;
}
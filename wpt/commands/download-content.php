<?php

add_usage('download-content',
          '',
          "Downloads WordPress into the directory, with the version specified in wpconfig.json or the newest version if not specified.");

function command_download_content() {
    global $argc, $argv;
    
    $config = parse_config();
    if ($config === FALSE) {
        exit;
    }
    
    if (!isset($config['contentServer'])) {
        fwrite(STDERR, "Incomplete config, please enter all required fields\r\n");
        fwrite(STDERR, "  {contentServer}\r\n");
        exit;
    }
    
    $filename = "{$config['id']}.tgz";
    $url = "http://{$config['contentServer']}/{$filename}";
    fwrite(STDOUT, "Downloading {$url}\r\n");
    
    $in = fopen($url, 'rb');
    $out = fopen($filename, 'w+b');
    if (!$in || !$out) {
        return false;
    }

    while (!feof($in)) {
        if (fwrite($out, fread($in, 4096)) === FALSE) {
            return false;
        }
        flush();
    }

    fclose($in);
    fclose($out);
    
    fwrite(STDOUT, "Unzipping {$filename}\r\n");
    shell_exec("tar -xzf {$filename}");
}
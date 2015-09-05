@echo off

set SubCmd=%1

:: Overridden from wp
if "%SubCmd%" == "" goto wptools
if "%SubCmd%" == "--info" goto wptools
if "%SubCmd%" == "help" goto wptools

if "%SubCmd%" == "help" goto wptools
if "%SubCmd%" == "create-config" goto wptools
if "%SubCmd%" == "create-vhost-entry" goto wptools
if "%SubCmd%" == "create-wp-config" goto wptools
if "%SubCmd%" == "create-db" goto wptools
if "%SubCmd%" == "download-wp" goto wptools
if "%SubCmd%" == "download-content" goto wptools
if "%SubCmd%" == "install" goto wptools
if "%SubCmd%" == "install-plugins" goto wptools
if "%SubCmd%" == "update-plugin-list" goto wptools
if "%SubCmd%" == "get-url" goto wptools
if "%SubCmd%" == "url-rewrite" goto wptools

if "%SubCmd%" == "cache" goto wp
if "%SubCmd%" == "cap" goto wp
if "%SubCmd%" == "cli" goto wp
if "%SubCmd%" == "comment" goto wp
if "%SubCmd%" == "core" goto wp
if "%SubCmd%" == "cron" goto wp
if "%SubCmd%" == "db" goto wp
if "%SubCmd%" == "eval" goto wp
if "%SubCmd%" == "eval-file" goto wp
if "%SubCmd%" == "export" goto wp
if "%SubCmd%" == "import" goto wp
if "%SubCmd%" == "media" goto wp
if "%SubCmd%" == "menu" goto wp
if "%SubCmd%" == "network" goto wp
if "%SubCmd%" == "option" goto wp
if "%SubCmd%" == "plugin" goto wp
if "%SubCmd%" == "post" goto wp
if "%SubCmd%" == "rewrite" goto wp
if "%SubCmd%" == "role" goto wp
if "%SubCmd%" == "scaffold" goto wp
if "%SubCmd%" == "search-replace" goto wp
if "%SubCmd%" == "shell" goto wp
if "%SubCmd%" == "sidebar" goto wp
if "%SubCmd%" == "site" goto wp
if "%SubCmd%" == "super-admin" goto wp
if "%SubCmd%" == "term" goto wp
if "%SubCmd%" == "theme" goto wp
if "%SubCmd%" == "transient" goto wp
if "%SubCmd%" == "user" goto wp
if "%SubCmd%" == "widget" goto wp

goto error

:wp
wp %*
goto end

:wptools
php %~dp0/wpt/wp-tools.phar %*
goto end

:error
echo "The command '%SubCmd%' was not found"

:end
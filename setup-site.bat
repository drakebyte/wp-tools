@echo off
setlocal enabledelayedexpansion

set DoHostfile=0
set DoVhost=0
set DoDBSetup=0
set DoFreshSetup=0
set DoDBImport=0
set DoWPDownload=0
set DoWPConfig=0
set DoPlugins=0
set DoContent=0

set argCount=0
for %%x in (%*) do (
	set /A argCount+=1
	if "%%~x" == "--all" (
		set DoHostfile=1
		set DoVhost=1
		set DoWPDownload=1
		set DoDBSetup=1
		set DoWPConfig=1
		set DoDBImport=1
		set DoPlugins=1
		set DoContent=1
	)
	if "%%~x" == "--all-fresh" (
		set DoHostfile=1
		set DoVhost=1
		set DoWPDownload=1
		set DoDBSetup=1
		set DoWPConfig=1
		set DoFreshSetup=1
		set DoPlugins=1
		set DoContent=1
	)
	if "%%~x" == "--hostfile" set DoHostfile=1
	if "%%~x" == "--vhost" set DoVhost=1
	if "%%~x" == "--wp-download" set DoWPDownload=1
	if "%%~x" == "--database-setup" set DoDBSetup=1
	if "%%~x" == "--wp-config" set DoWPConfig=1
	if "%%~x" == "--fresh-setup" set DoFreshSetup=1
	if "%%~x" == "--database-import" set DoDBImport=1
	if "%%~x" == "--plugins" set DoPlugins=1
	if "%%~x" == "--content" set DoContent=1
)

if %DoHostfile% == 1 (
	echo Adding entry to hostfile
	
	:: Store the result of 'wpt get-url local' in the F variable
    for /F "tokens=* USEBACKQ" %%F in (`wpt get-url local`) do ( 
		:: Add a newline to the hosts file, and then append '127.0.0.1 URL' where URL was defined above
		echo. >> C:\Windows\System32\drivers\etc\hosts
		echo 127.0.0.1 %%F >> C:\Windows\System32\drivers\etc\hosts
	)
)

if %DoVhost% == 1 (
	echo Creating vhost entry
	
    call wpt create-vhost-entry c:\xampp\apache\conf.d\
    call net stop Apache2.4
    call net start Apache2.4
)

if %DoWPDownload% == 1 (
	echo Downloading WP
	
    call wpt download-wp
)

if %DoDBSetup% == 1 (
	echo Creating MySQL Database and User
	
    call wpt create-db root
)

if %DoWPConfig% == 1 (
	echo Creating WP Config
	
    call wpt create-wp-config
)

if %DoFreshSetup% == 1 (
	echo Creating a fresh wordpress install using config.json
	
    call wpt install local
)

if %DoDBImport% == 1 (
	echo Importing and Rewriting Database
	
    call wpt db import database.sql
    call wpt url-rewrite prod local
)

if %DoPlugins% == 1 (
	echo Installing Plugins
	
    call wpt install-plugins
)

if %DoContent% == 1 (
	echo Downloading Content
	
    call wpt download-content
)

if %DoHostfile% == 0 if %DoVhost% == 0 if %DoDBSetup% == 0 if %DoDBImport% == 0 if %DoWPDownload% == 0 if %DoWPConfig% == 0 if %DoPlugins% == 0 if %DoContent% == 0 (
    echo Usage setup-site [OPTION]...
	echo Performs the steps needed to setup a wordpress site
	echo.
	echo   --all                  run all of the following steps
	echo   --all-fresh            run all of the following steps EXCEPT 
	echo                            it will install a clean default wordpress site
	echo   --hostfile             add a hostfile entry for 127.0.0.1 [sitename]
	echo                            in "C:\Windows\System32\drivers\etc\hosts"
	echo   --vhost                add a vhost entry for the site in "C:\xampp\apache\conf.d\"
	echo   --wp-download          downloads wordpress
	echo   --database-setup       creates the database and users with the username root and
	echo                            no password
	echo   --wp-config            creates the wp-config.php file
	echo   --database-import      imports the database from database.sql
	echo   --plugins              installs all plugins listed in the wpconfig.json
	echo   --content              downloads the content from the given contentServer
)
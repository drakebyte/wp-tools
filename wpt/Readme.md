## WP Tools Command Line Utility

A command to assist our development, by creating commands out of tasks 

#### Usage
```
wpt SUBCMD OPTIONS
```

*Note:* This tool requires the 'wp' and 'mysql' commands to be installed as well.

*Note:* This tool requires a configuration file named wpconfig.json in order to run. Please run this command in the same directory as this file.

This command can run all the same commands as the 'wp' command

#### WP Tools Specific Subcommands

**```
info
```**

Displays the current version of wptools as well as the contents of the wpconfig.json file if it exists

**```
create-config
```**

Save a blank wpconfig.json file in the current directory with the minimum set of options needed.
   
**```
create-vhost-entry CONF_DIR
```**

Saves a file named [website]-vhost.conf in the given CONF_DIR with an apache <VirtualServer> directive within it.        

*Note:* CONF_DIR will usually be /etc/httpd/conf.d/ on CentOS Linux and C:/xampp/apache/conf.d/ on Windows

**```
create-wp-config
```**

Uses the options in wpconfig.json to create a wp-config.php file using the 'wp' command. 

**```    
create-db [MYSQL_USER] [MYSQL_PASS]
```**

Uses the options in wpconfig.json to create a database and user by calling the mysql command.
        
*Note:* [MYSQL_USER] and [MYSQL_PASS] are not required, but may need to be set to allow the tool to create the database.

**```
download-wp
```**

Downloads WordPress into the directory, with the version specified in wpconfig.json or the newest version if not specified

**```
download-content
```**

Downloads the site content from the content server specified by 'contentServer' in the wpconfig.json. The full URL to be downloaded is 'contentServer'/'id'.tgz

*Example:* http://wpcontentdeva.cloud.mywebgrocer.com/celebration.com.tgz

**```    
install URL
```**

Installs a new wordpress site to using 'wp core install' and the options in wpconfig.json

**```        
install-plugins
```**

Installs the plugins outlined in wpconfig.json with the versions specified, and activates them.

**```    
update-plugin-list
```**

Updates wpconfig.json with the current list of active plugins and their versions.

**```
get-url URL
```**

Outputs the url from the config file with the given ID.
        
*Example:*
```
wptools get-url prod
```
would output www.celebrations.com
        
**```        
url-rewrite FROM_URL TO_URL
```**

Performs a search-and-replace on the database with the given URLs. The URLs will be pulled from the 'urls' section of the wpconfig.json file
        
*Example:* wptools url-rewrite prod local
This will rewrite all production URLs in the database and replace them with the local URLs as they are defined in the wpconfig.json

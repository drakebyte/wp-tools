@echo off
call wpt url-rewrite local prod
call wpt db export --compatible=mysql4 database.sql
call wpt url-rewrite prod local
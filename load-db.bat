@echo off
call wpt db import database.sql
call wpt url-rewrite prod local
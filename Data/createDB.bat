@echo off

ECHO This action will completely delete any existing database.
set /p selection=Are you sure you wish to continue? [y/n]?:
echo %selection%
IF "%selection%" == "y" (
	IF EXIST users.db (
		del users.db
	)
	sqlite3 users.db < "createDB.sql"
) 
pause
#!/bin/bash
# WARNING THIS SCRIPT WILL DELETE ANY EXISTING DB
read -p "This action will completely delete any existing database. Are you sure you wish to continue? [y/n]" selection; 
if [ $selection == "y" ] 
then 
	if [ -f users.db ]; then
		rm users.db
	fi
	sqlite3 users.db < createDB.sql
fi

chmod a+rwx users.db
chmod a+rwx .
#!/bin/bash
# WARNING THIS SCRIPT WILL DELETE ANY EXISTING DB
read -p "This action will completely delete any existing database. Are you sure you wish to continue? [y/n]" selection; 
if [ $selection == "y" ] 
then 
	rm users.db
	sqlite3 users.db < createDB.sql
fi
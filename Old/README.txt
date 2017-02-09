Health Net README

This document will be packaged with the Health Net website files. Its purpose is to explain how to get the
developement website running on your system. 
Please make sure that you have Django 1.6.5 installed as well as SQLite 3 and Python 3.2.2.
Internet Explorer 10, Google Chrome 40, and Mozilla Firefox 36 are the supported web browsers.
Inside the same folder as this document, there is a file titled buglist, which contains all current, known bugs


Starting the Developement server by running the bash file:
1. Locate \Python32 and \Python32\Scripts on your local machine and add them to your system PATH.
2. Double click on clean.bat
The server should now start on it's own
3. You can now view the developement server by typing "127.0.0.1:8000" into a web browser.

Starting the Developement server manually:
1. Locate \Python32 and \Python32\Scripts on your local machine and add them to your system PATH.
2. Navigate to the \HealthNet_Project\HealthNet\healthnet directory in the provided files in 
a windows command line.
3. Run the command "Python manage.py syncdb"
4. Run the command "Python mange.py migrate"
5. Run the command "Python manage.py runserver"
6. You can now view the developement server by typing "127.0.0.1:8000" into a web browser.




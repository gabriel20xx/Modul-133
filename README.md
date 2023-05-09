# Modul-133

This is our Website called "The GCT Corner" made for our school project in the module M133 from Gerd Gesell

All content is self made with heart and hard work. We, Cornel, Gabriel and Till have the full rights of it. Nothing is stolen or illegal.

The Website is located at http://35.208.0.218/ and is for testing purposes only.


Installation
This is the installationguide for the webserver for the website on a linux debian/ubuntu system:
1.	apt update && apt upgrade -y
2.	apt install apache2 apache-php php-uuid git
3.	cd /var/www/html
4.	rm -dfr *
5.	git init https://github.com/gabriel20xx/Modul-133.git
6.	git pull

Installation of the database:
1.	Run the file «create-database.sql» on the mysql server
2.	Edit the file «connect-db.php » in «Modul-133/includes/» with the appropriate values of the mysql server


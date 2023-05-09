# Modul-133

This is our Website called "The GCT Corner" made for our school project in the module M133 from Gerd Gesell

All content is self made with heart and hard work. We, Cornel, Gabriel and Till have the full rights of it. Nothing is stolen or illegal.

The Website is located at http://35.208.0.218/ and is for testing purposes only.


Installationsanleitung
Dies ist die Installationsanleitung des Webservers der Webseite auf einem Linux Debian/Ubuntu Betriebssystem:
1.	apt update && apt upgrade -y
2.	apt install apache2 apache-php php-uuid git
3.	cd /var/www/html
4.	rm -dfr *
5.	git init https://github.com/gabriel20xx/Modul-133.git
6.	git pull

Installationsanleitung für die Datenbank:
1.	Führe die Datei «create-database.sql» auf dem MySQL Server aus
2.	Passe die Datei «connect-db.php » in «Modul-133/includes/» mit den Daten des MySQL Servers an


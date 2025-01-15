# How to install 

## Spesification
	- using php v7.2
	- using composer
	- using redis
	- using mariadb
	
## Installation
On macos using xampp v7.2. with following [Download Xampp V7.2](https://sourceforge.net/projects/xampp/files/XAMPP%20Mac%20OS%20X/7.2.31/xampp-osx-7.2.31-0-installer.dmg/download)

## Setup Xampp
- setup file /Xampp/etc/http.conf, uncomment line etc/extra/httpd-vhosts
```
...

# Virtual hosts
Include etc/extra/httpd-vhosts.conf

...
```

- add this code in in folder etc/extra/httpd-vhosts.conf
```
<VirtualHost *:80>
    ServerAdmin webmaster@site.com
    DocumentRoot "/Applications/XAMPP/htdocs/pbtaxand"
    ServerName pbtaxand.localhost
    <Directory "/Applications/XAMPP/htdocs/pbtaxand">
        ServerSignature Off
        Options Indexes FollowSymLinks IncludesNoExec
        AllowOverride All

        #Order allow,deny  <- You can remove this
        #Allow from all    <- and that

        # Insert the following:
        Require all granted

    </Directory>
</VirtualHost>

```

## Setup Composer
```sh
> pwd
 /Application/Xampp/htdocs/pbtaxand
> composer install
```

## Set up env
```sh
> pwd
 /Application/Xampp/htdocs/pbtaxand
> cp .venv.example .venv
```

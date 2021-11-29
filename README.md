# CryptPaste
## The free open source way to store encrypted text.

## How it works
First your input is encrypted in the browser with javascript, then it is encrypted with php with AES-256 just like decrypting, we don't store keys. So even in case of a database breach nothing can be leaked. This could be extended with for example a login and a private area. 

## Demo
https://paste.softwarelara.com/
## 

- Material Design Lite
- CryptoLib by Google

## How to use

First you upload everything to your WebServer, then you open /admin/config.php there you add all your MySQL data and change all links to yours.  When you have done that, open the installer.php in your browser and the rest will take care of itself, if everything worked without errors then the tool is fully installed.

## What you need

- WebServer with PHP 7+
- MySQL Database

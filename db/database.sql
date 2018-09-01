create database if not exists projetweb character set utf8 collate utf8_unicode_ci;
use projetweb;

grant all privileges on projetweb.* to 'projetweb_user'@'localhost' identified by 'secret';

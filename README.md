# PHP rühmatöö projekt
**Rühmatööde demo päev** on valitud eksamipäev jaanuaris, kuhu tuleks tullakse terve rühmaga koos!

## Tööjuhend
1. Üks rühma liikmetest fork'ib endale käesoleva repositooriumi ning annab teistele kirjutamisõiguse/ligipääsu
1. Tee kohe Pull request
1. Muuda repositooriumi README.md faili vastavalt nõutele
1. Tee valmis korralik veebirakendus

### Nõuded

1. **README.md sisaldab:**
    * suurelt projekti nime;
    * rühma liikmete nimed;
    * eesmärki (3-4 lauset, mis probleemi üritate lahendada);
    * kirjeldus (sihtrühm, eripära võrreldes teiste samalaadsete rakendustega - kirjeldada vähemalt 2-3 sarnast rakendust mida eeskujuks võtta);
    * funktsionaalsuse loetelu prioriteedi järjekorras, nt
        * v0.1 Saab teha kasutaja ja sisselogida
        * v0.2 Saab lisada huviala
        * ...
    * andmebaasi skeem loetava pildina + tabelite loomise SQL laused;
    * **kokkuvõte:** mida õppisid juurde? mis ebaõnnestus? mis oli keeruline? (kirjutab iga tiimi liige).


2. **Veebirakenduse nõuded:**
    * kasutusel on vähemalt 6 tabelit;
    * kood on jaotatud klassidesse;
    * muutujad/tabelid on inglise keeles;
    * rakendus on piisava funktsionaalsusega ja turvaline;
    * kõik tiimi liikmed on panustanud rakenduse arendusprotsessi.

## Abiks
* **Testserver:** greeny.cs.tlu.ee, [tunneli loomise juhend](http://minitorn.tlu.ee/~jaagup/kool/java/kursused/09/veebipr/naited/greenytunnel/greenytunnel.pdf)
* **Abiks tunninäited (rühmade lõikes):** [I rühm](https://github.com/veebiprogrammeerimine-2015s?utf8=%E2%9C%93&query=-I-ruhm), [II rühm](https://github.com/veebiprogrammeerimine-2015s?utf8=%E2%9C%93&query=-II-ruhm), [III rühm](https://github.com/veebiprogrammeerimine-2015s?utf8=%E2%9C%93&query=-III-ruhm)
* **Stiilijuhend:** [Coding Style Guide](http://www.php-fig.org/psr/psr-2/)
* **GIT õpetus:** [Become a git guru.](https://www.atlassian.com/git/tutorials/)
* **Abimaterjale:** [Veebirakenduste loomine PHP ja MySQLi abil](http://minitorn.tlu.ee/~jaagup/kool/java/loeng/veebipr/veebipr1.pdf), [PHP with MySQL Essential Training] (http://www.lynda.com/MySQL-tutorials/PHP-MySQL-Essential-Training/119003-2.html)

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

Rühm team_alpha rühmaliikmed on: [Janek Kossinski](https://github.com/janekos) , [Ruslan Jegorov] (https://github.com/RuziGg) ja [Ea Rist] (https://github.com/earist)
- Projekti nimi: Eesti Post
- Projekti eesmärk: võimaldada tavakasutajatel ilma sisselogimata jälgida oma saadetiste teekonda ja (sisseloginud) postitöötajatel 
vaadata viimatisi saadetisi, lisada uusi saadetisi ja otsida saadetisi erinevate kriteeriumite järgi. Veebileht on põhiliselt
mõeldud postitöötajate töö hõlbustamiseks. 
- Kirjeldus: sihtrühmaks on peamiselt postitöötajad ja lisaks ka kõik inimesed, kes soovivad oma saadetist jälgida (vanusepiiranguid pole)
- Rakendused eeskujuks: Omniva https://www.omniva.ee/index.php, DHL http://www.dhl.ee/et.html ja UPS https://www.ups.com 
- Funktsionaalsuse loetelu:
	* v0.1 Postitöötajale kasutaja loomine ja töö alustamiseks sisselogimine
	* v0.2 Viimaste saadetiste vaatamine
	* v0.3 Uue saadetise lisamine
	* v0.4 Saadetiste otsimine id, lähteriigi, pakendi märkuste järgi, kontorite(sihtkoha) järgi, 
	* v0.5 Saadetiste muutmine
- SQL laused:

CREATE TABLE IF NOT EXISTS `if15_teamalpha_3`.`kontorid` (
  `kontor_id` INT NULL COMMENT '',
  `kontor` VARCHAR(255) NOT NULL COMMENT '',
  PRIMARY KEY (`kontor_id`)  COMMENT '')
ENGINE = InnoDB;


CREATE TABLE `post_import` (
  `saadetis_id` INT NOT NULL AUTO_INCREMENT,
  `saabumine` DATETIME NOT NULL,
  `valjumine` DATETIME NOT NULL,
  `lahteriik` VARCHAR(45) NULL,
  `markus` TEXT NULL,
  
select * from post_import;
+-------------+---------------------+---------------------+-------------+-----------------------------------+-----------+
| saadetis_id | saabumine           | valjumine           | lahteriik   | markus                            | kontor_id |
+-------------+---------------------+---------------------+-------------+-----------------------------------+-----------+
|           1 | 2015-10-12 18:14:51 | 2015-10-12 02:37:12 | hiina       | Pakend on korras                  |         1 |
|           2 | 2015-10-12 18:15:29 | 2015-10-12 02:38:14 | eesti       | Pakend on korras                  |         1 |
|           3 | 2015-10-12 19:02:31 | 0000-00-00 00:00:00 | eesti       | Pakend lekib                      |         1 |
|           4 | 2015-10-12 19:15:21 | 2015-10-12 03:45:23 | soome       | Pakend on korras                  |         2 |
|           5 | 2015-10-12 19:21:34 | 2015-10-12 04:12:22 | soome       | Pakend on kortsus                 |         2 |
|           6 | 2015-10-12 19:33:11 | 0000-00-00 00:00:00 | eesti       | Pakend on korras                  |         2 |
|           7 | 2015-10-12 20:01:31 | 0000-00-00 00:00:00 | eesti       | Pakend on korras                  |         3 |
|           8 | 2015-10-12 20:13:45 | 0000-00-00 00:00:00 | eesti       | Pakend lekib                      |         3 |
|           9 | 2015-10-12 21:03:21 | 2015-10-12 05:33:22 | hiina       | Pakend sisaldab illegaalset kaupa |         3 |
|          10 | 2015-10-12 21:34:51 | 2015-10-12 05:35:52 | louna_korea | Pakend on korras                  |         4 |
|          11 | 2015-10-12 21:55:19 | 2015-10-12 05:23:43 | louna_korea | Pakend on kortsus                 |         4 |
|          12 | 2015-10-28 19:15:21 | 0000-00-00 00:00:00 | soome       | Pakend lekib                      |         4 |
|          13 | 2015-11-12 16:15:31 | 2015-11-01 03:39:22 | venemaa     | Pakend on kortsus                 |         5 |
|          14 | 2015-11-02 17:14:11 | 0000-00-00 00:00:00 | hiina       | Pakend on korras                  |         5 |
|          15 | 2015-11-03 13:49:13 | 2015-10-27 16:38:32 | inglismaa   | Pakend on kortsus                 |         5 |
|          16 | 2015-10-18 13:14:31 | 2015-10-11 08:21:14 | venemaa     | Pakend on kortsus                 |         6 |
|          17 | 2015-10-17 15:15:15 | 0000-00-00 00:00:00 | venemaa     | Pakend lekib                      |         6 |
|          18 | 2015-10-06 19:23:44 | 2015-10-07 14:32:21 | hiina       | Pakend on korras                  |         6 |
|          19 | 2015-10-01 12:34:11 | 2015-10-01 17:47:52 | saksamaa    | Pakend on korras                  |         7 |
|          20 | 2015-10-15 13:56:31 | 2015-10-05 16:48:32 | inglismaa   | Pakend on väga halvas seisundis   |         7 |
|          21 | 2015-10-15 14:13:22 | 2015-10-07 15:22:23 | hiina       | Pakend on korras                  |         7 |
+-------------+---------------------+---------------------+-------------+-----------------------------------+-----------+

CREATE TABLE `lasna` (
  `saadetis_id` INT NOT NULL,
  `saabumine` DATETIME NOT NULL,
  `valjumine` DATETIME NOT NULL,
  `markus` VARCHAR(45) NULL,
  
  mysql> select * from lasna;
+-------------+---------------------+---------------------+------------------+-----------+
| saadetis_id | saabumine           | valjumine           | markus           | kontor_id |
+-------------+---------------------+---------------------+------------------+-----------+
|           1 | 2015-10-13 13:56:31 | 2015-10-14 16:48:32 | Pakend on korras |         1 |
|           2 | 2015-10-13 23:56:12 | 2015-10-14 16:55:42 | Pakend on korras |         1 |
+-------------+---------------------+---------------------+------------------+-----------+


CREATE TABLE `kopli` (
  `saadetis_id` INT NOT NULL AUTO_INCREMENT,
  `saabumine` DATETIME NOT NULL,
  `valjumine` DATETIME NOT NULL,
  `markus` VARCHAR(45) NULL,
  
  mysql> select * from kopli;
+-------------+---------------------+---------------------+--------------------+-----------+
| saadetis_id | saabumine           | valjumine           | markus             | kontor_id |
+-------------+---------------------+---------------------+--------------------+-----------+
|           4 | 2015-10-13 13:54:22 | 2015-10-14 16:32:12 | Pakend on korras   |         2 |
|           5 | 2015-10-13 13:56:29 | 2015-10-14 16:40:13 | Pakend oli kortsus |         2 |
+-------------+---------------------+---------------------+--------------------+-----------+



CREATE TABLE `kristiine` (
  `saadetis_id` INT NOT NULL,
  `saabumine` DATETIME NOT NULL,
  `valjumine` DATETIME NOT NULL,
  `markus` VARCHAR(45) NULL,
  
  mysql> select * from kristiine;
+-------------+---------------------+---------------------+--------------+-----------+
| saadetis_id | saabumine           | valjumine           | markus       | kontor_id |
+-------------+---------------------+---------------------+--------------+-----------+
|           9 | 2015-10-15 23:56:12 | 2015-10-16 23:56:12 | Pakend lekib |         3 |
+-------------+---------------------+---------------------+--------------+-----------+



CREATE TABLE `pirita` (
  `saadetis_id` INT NOT NULL,
  `saabumine` DATETIME NOT NULL,
  `valjumine` DATETIME NOT NULL,
  `markus` VARCHAR(45) NULL,
  
  mysql> select * from pirita;
+-------------+---------------------+---------------------+-----------------------------------+-----------+
| saadetis_id | saabumine           | valjumine           | markus                            | kontor_id |
+-------------+---------------------+---------------------+-----------------------------------+-----------+
|          10 | 2015-10-14 13:23:23 | 2015-10-13 06:43:52 | Pakend sisaldab illegaalset kaupa |         4 |
|          11 | 2015-10-15 15:39:21 | 2015-10-13 13:38:01 | Pakend on korras                  |         4 |
+-------------+---------------------+---------------------+-----------------------------------+-----------+



CREATE TABLE `nomme` (
  `saadetis_id` INT NOT NULL,
  `saabumine` DATETIME NOT NULL,
  `valjumine` DATETIME NOT NULL,
  `markus` VARCHAR(45) NULL,
  
  mysql> select * from nomme;
+-------------+---------------------+---------------------+----------------------+-----------+
| saadetis_id | saabumine           | valjumine           | markus               | kontor_id |
+-------------+---------------------+---------------------+----------------------+-----------+
|          13 | 2015-10-22 10:00:00 | 2015-10-21 10:01:13 | Pakend on lekib      |         5 |
|          15 | 2015-10-28 13:56:31 | 2015-10-30 16:48:32 | Pakend on purustatud |         5 |
+-------------+---------------------+---------------------+----------------------+-----------+



CREATE TABLE IF NOT EXISTS `mustamae` (
  `saadetis_id` INT NOT NULL,
  `saabumine` DATETIME NOT NULL,
  `valjumine` DATETIME NOT NULL,
  `markus` VARCHAR(45) NULL,

  mysql> select * from mustamae;
+-------------+---------------------+---------------------+----------------------+-----------+
| saadetis_id | saabumine           | valjumine           | markus               | kontor_id |
+-------------+---------------------+---------------------+----------------------+-----------+
|          16 | 2015-10-12 13:56:31 | 2015-10-14 16:48:32 | Pakend on purustatud |         6 |
|          18 | 2015-10-08 13:56:31 | 2015-10-15 16:48:32 | Pakend on korras     |         6 |
+-------------+---------------------+---------------------+----------------------+-----------+


CREATE TABLE `oismae` (
  `saadetis_id` INT NOT NULL,
  `saabumine` DATETIME NOT NULL,
  `valjumine` DATETIME NOT NULL,
  `markus` VARCHAR(45) NULL,
  
  mysql> select * from oismae;
+-------------+---------------------+---------------------+----------------------+-----------+
| saadetis_id | saabumine           | valjumine           | markus               | kontor_id |
+-------------+---------------------+---------------------+----------------------+-----------+
|          19 | 2015-10-02 13:56:31 | 2015-10-05 16:48:32 | Pakend on korras     |         7 |
|          20 | 2015-10-07 13:56:31 | 2015-10-10 16:48:32 | Pakend on purustatud |         7 |
|          21 | 2015-10-09 13:56:31 | 2015-10-11 16:48:32 | Pakend on korras     |         7 |
+-------------+---------------------+---------------------+----------------------+-----------+


  create table kontorid(
  kontor varchar(255),
  kontor_id int,
  foreign key);
  
+-----------+-----------+
| kontor_id | kontor    |
+-----------+-----------+
|         1 | lasna     |
|         2 | kopli     |
|         3 | kristiine |
|         4 | pirita    |
|         5 | nomme     |
|         6 | musatamae |
|         7 | oismae    |
+-----------+-----------+



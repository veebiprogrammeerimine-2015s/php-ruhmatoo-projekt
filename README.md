# 3. kodutoo (I rühm)

 * #JOOKS24
	
    * ###Liikmed:
	Karl Markus Wahlberg, Katariina Linde
	
    * ###Eesmärk: 
	Aidata jooksuhuvilistel registreerida jooksudele. 
	
    * ###Sihtrühm, eripära:
	Spordihuvilised. Eripära on see, et lisaks registreerimisele on see ka sotsiaalse suunitlusega. Jooksjad saavad enda tulemusi kirja panna ning kogemusi kirjeldada.
	Selleks tuleb kasutaja luua, sisse logida, valida jooks ja broneerida.
	Edasi on vajalik kinnitus ning kui on joostud, saab sisestada ka tulemuse ja anda tagasisidet jooksuürituse kohta ning enda vormi kohta.
	###Sarnased: 
		* <a href="http://www.marathon100.com">marathon100</a>
		* <a href="http://www.jooks.ee">jooks.ee</a>
	
    * ###Funktsionaalsuse loetelu prioriteedi järjekorras:
        * v0.1 Saab teha kasutaja ja sisselogida
        * v0.2 Saab registreerida jooksule
        * v0.3 Saab kinnitada jooksu
		* v0.4 Tabel, kus on tulemused
		* v0.5 Jooksu tagasiside tabel
		* v0.6 Huvialade tabel, kasutajate ühised huvid
		
    * andmebaasi skeem loetava pildina + tabelite loomise SQL laused;
    * **kokkuvõte:** mida õppisid juurde? mis ebaõnnestus? mis oli keeruline? (kirjutab iga tiimi liige).


1. Lähtu ülesannete puhul alati oma ideest ning ole loominguline
  * loo vähemalt 1 tabel andmete hoidmiseks (lisa table.txt fail tabeli kirjeldusega)
  * ainult sisseloginud kasutaja saab kirjeid tabelisse lisada
  * kirjeid saab muuta
  * kõik või ainult kasutaja ise saab enda lisatud kirjeid vaadata (oleneb rakendusest)
  * otsing
  * abi saad tunnitöödest 5, 6 ja 7

1. **OLULINE! ÄRA POSTITA GITHUBI GREENY MYSQL PAROOLE.** Selleks toimi järgmiselt:
  * loo eraldi fail `config.php`. Lisa sinna kasutaja ja parool ning tõsta see enda koduse töö kaustast ühe taseme võrra väljapoole
  ```PHP
  $servername = "localhost";
  $username = "username";
  $password = "password";
  ```
  * Andmebaasi nimi lisa aga kindlasti enda faili ja `require_once` käsuga küsi parool ja kasutajanimi `config.php` failist, siis saan kodust tööd lihtsamini kontrollida
  ```PHP
  // ühenduse loomiseks kasuta
  require_once("../config.php");
  $database = "database";
  $mysqli = new mysqli($servername, $username, $password, $database);
  ```

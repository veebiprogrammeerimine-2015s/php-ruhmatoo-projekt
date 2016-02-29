# Riiulifirma portfoolio leht
Testimise keskkond admin.php jaoks:
greeny.cs.tlu.ee/~richaas/login.php
User: demo@demo.com
Password: demodemo

1. **Tööst**
    * Rühma liikmed: Richard Aasa;
    * Eesmärk: luua portfoolio leht n.ö ühe mehe riiulifirmale;
    * **Kirjeldus:**
		* Klient
      * Saab registreerimata teha üldsõnalise tellimuse (tulevikus ehk OAuth kasutusele võtta).
      * Saab lugeda firma kohta infot.
		* Firmajuht
      * Saab arveldust pidada.
			* Saab töötajatele märmeid teha.
    * Haldaja/töötaja
      * Saab muuta todo.
      * Saab lisada kulu/tulu arvelduse tabelisse
      * Saab postitada firma blogisse
    * Tabelid
      * users - firma haldajatele mõeldud logimissüsteem.
      * orders - pealehel tehtud üldsõnaline tellimus. Näiteks "Soovin kodulehte - kontakt: demo@demo.com; summa: 50 eurot".
      * accounting - id, description, amount, hours, user_id, order_id
        * Kulud/tulud, ajakulu kui tegu on tellimusega, hours ja order_id on valikulised.
      * notes - märkmed teistele haldajatele, ainult admin(firmajuht) saab neid teha.
      * todos - kõigi haldajate poolt muudetav tegevuste nimekiri.
      * blog_posts - firma blogi postitused.
      * blog_tag_color - iga postitusel on oma tag ja iga tag omab värvi.

    * **funktsionaalsuse loetelu prioriteedi järjekorras**
        * V1.0 – Üldine lehekülg valmis, tuleb tabeleid integreerida.
        * V1.1 - Ühendus andmebaasiga, PDO.
        * V1.2 - User ja Post klass. Blogi vaade ja logimise süsteem.
        * V1.3 - Admin paneel postituste lisamiseks/redigeerimeks valmis. Autentimine logimisel.
        * V1.4 - Pildi mahu suurendamine.


    **kokkuvõte: mida õppisid juurde? mis ebaõnnestus? mis oli keeruline? (kirjutab iga tiimi liige).**
      * Mida rohkem on andmebaasi struktuur paigas alguses, seda vähem peab pärast vaeva nägema. Ehk iga kord,
      kui tekib uus väli või tabel, peab klasse muutma, klassidele vastavaid vaateid muutma, muud loogikat muutma.
      * Jälgida mingit struktuuri (MVC, MVVM jne.), kuna asjad kuhjusid kiiresti ühte kausta.
      * PHP'd kasutan tulevikus järgnevaks: kerge template süsteem; andmebaasi andmete muutmine JSON kujule; räsi genereerimise/autentimise jaoks; PDO; serveripoolse
      valideerimise jaoks.
      * PHP tulevikus ei kasuta järgnevaks: HTML'i genereerimiseks, selle all mõtlen näiteks praegusel kujul blogi vaate loomist. Oleks palju otstarbekam
      ja loetavam olnud tõmmata andmed andmebaasist JSON kujul ja sisestada vajalik HTML Javascript'i abil (+ salvestada localStorage'i sisse).
      * Pole mõtet ratast uuesti leiutada - näiteks logimise süsteemil on palju agasid mida tuleb jälgida, kergem on toetuda raamistiku peale.
      * Ebaõnnestusin arveldussüsteemi loomisel, kuna tahaks kaasata asju nagu Google Calendar, Google Auth, statistika graafiline kujutus.
      * Ebaõnnestus tellimusvormi loomine, märkme süsteem, todo list'i tegemine. Üldiselt sellepärast, et need ei tundunud vajalikuna. Tellimusvorm oleks
      rätseplahendus (mis väljad? kas e-maili kaudu saadetakse? broneerimine?).

	**Richard Aasa:**

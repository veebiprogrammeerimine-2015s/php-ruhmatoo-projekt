#KINGS OF COCKTAILS
* [Koduleht](http://greeny.cs.tlu.ee/~kaurkal/GT_Kaur_Tauno_Koit/php-ruhmatoo-projekt/grupitoo3/page/home.php)

##Liikmed
* Kaur Kaljuma, Tauno Lainevool, Koit Korela

##Eesmärk 
* **Mis probleemi lahendame:** Kus saada tõeliselt erilist kokteilielamust?
* **Kuidas seda lahendame:** Kriitikud koostavad edetabeli parimatest kokteilibaaridest
* **Pakutav lisaväärtus:** Ettevõtted on pildis (hilisem teenimise võimalus)

##Kirjeldus 
* **Idee kirjeldus:** Veebileht, millel on koostatud edetabel parimatest Eesti kokteilibaaridest. Kriitikud käivad söögi- ja meelelahutusasutustes hindamas just kokteilielamust ning koostavad pingerea, et selgitada välja parimaid kokteile pakkuvad asutused.
* **Sihtrühm:** Inimesed, kes ei taha end lihtsalt täis juua, vaid otsivad kokteili nautimisest uut elamust. 28+ aastased keskmise või kõrgema sissetulekuga inimesed.
* **Konkurendid:** Hindamine ja pingerea koostamine toimub sarnaselt "Eesti Maitsed - Eesti parimad restoranid", kuid keskendutud on ainult kokteilelamusele. Seetõttu saavad kategoorias osaleda ka kohad, kus ei pakuta sööki või on köögipool nõrk.


##Progress
* **Funktsionaalsuse loetelu:**
   * v0.1 Valmis on rippmenüü ja avaleht (OK)
   * v0.2 Inimene saab end lehel registreerida kasutajaks (OK)
   * v0.3 Kasutaja saab sisse logida (OK)
   * v0.4 Kasutaja saab sisestada portaali infot (OK)
   * v0.5 Kodulehe külastaja näeb tabelina infot, mida kasutajad on portaali sisestanud (OK)
   * v0.6 Portaal on testitud (OK)
   * v0.7 Lisasime sponsorite lehe (OK)
   * v0.8 Lisasime kasutaja profiili ja kasutaja pildi lisamise funktsiooni (OK)
   * v1.0 Portaal on kasutajatele avatud

* **[MySQL tabelid ja käsud](http://www.tlu.ee/~kkkaur/PHP/MySQL_for_PHP.JPG)**

##Kokkuvõte
* **Kaur:** 
   * **Mida õppisin juurde:** Andmebaaside loomise loengust on mul MySQL päris selge, kuid alati oli küsimus, et kuidas ma neid tabeleid saan inimesele "käega katsutavaks" teha. Nüüd muutus PHP ja MySQL-i omavaheline seos selgemaks. Muutusid loogiliseks ka PHP-käsud, kuidas info liigub ja tekkis pilt, et PHP on tegelikult päris loogiline keel (info saatmine erinevate lehtede vahel, erinevad funktsioonid ja nende koondamine ühele lehele ning nende kasutamine teistel lehtedel, muutujate määramine ja nende kasutamine jpm). Kasutajate loomine, sisselogimine, andmete sisestamine andmebaasi ja nende andmete kuvamine veebilehel said tehtud läbi ka tunnis, kuid kuna ükski kood ei ole kunagi täpselt sama, siis enda portaalile nende rakenduste tegemine andis mulle nendest parema ülevaate ja kinnistas nende rakenduste tööpõhimõtet.
   * **Mis ebaõnnestus:** Grupi kokkulepitud ajal kohtumine ja võrdne panustamine.
   * **Mis oli keeruline:** Kodulehel info sisestamine, selle saatmine andmebaasi ja pärast andmebaasis oleva info kuvamine kodulehel. Sain veateate functions.php lehelt, kuigi tegelikult oli viga sellel lehel, mis infot functions.php lehele saatis (hiljem meenus, et õppejõud rääkis ka tunnis, et PHP-s ei pruugi andmebaaside errorite puhul viga olla tegelikult seal, mis veateates kirjas). Selle vea otsimine ja parandamine oli üsna aeganõudev, kuid väga huvitav ja kui lõpuks selle lahendatud sain, oli kuidagi eufooriline tunne.

* **Tauno:**
   * **Mida õppisin juurde:** Õppisin juurde php funktsioonide liikumise, kuidas funktsioon liigub erinevate lehtede vahel. Sain kogemusi php koodi lugemisel ja selle kirjutamisel.
   * **Mis ebaõnnestus:** Oli raske leide sobivat aega grupitööks
   * **Mis oli keeruline:** Keeruline oli luua huvialade tabelit, mida oleks võimalik muuta ja kustutada.
 
* **Koit:**
   * **Mida õppisin juurde:** Kuidas sisestada andmeid ja parandasin enda oskusi HTML-is, PHP-s ja mysql-is.
   * **Mis ebaõnnestus:** Rühma aja planeerimine.
   * **Mis oli keeruline:** Veebilehe ühtne toimimine.



------------------
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

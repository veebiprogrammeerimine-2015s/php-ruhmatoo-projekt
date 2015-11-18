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

Projekti nimi: Dead Video Storage

projekti kirjeldus: Videolaenutus läbi interneti. Inimene loob konto veebilehele ning saab "laenutada" piiratud ajaks digitaalse video. Selle ajal jooksul saab ta videot streamida (voogesitada) nii palju kui ta tahab. Kui laenutuse aeg lõppeb siis ta kaotab ligipääsu videole. Sellele sarnanevad lahendused on näiteks Netflix, Elioni DigiTV videolaenutus, Videoplanet (Kahjuks tänapäeval pankrotis, üritame sama viga mitte korrata). Sihtrühmaks on eelkõige Eestlased, sest me pakuks ligipääsu ka Eesti filmidele ning sarjadele, mida välismaa konkurendid ei paku. Vanusgruppidest pigem noored täiskasvanud, kuskil 20-30 ning tõenäoliselt ka mõned keskealised(valmis rohkem raha maksma).

Rühma liikmed: [Robin Ginter](https://github.com/Dralun), [Toomas Lõõnik](https://github.com/tom07140)

Eesmärk: Luua mugavam videolaenutusteenus kui füüsiliselt andmekandjate rakendamine. Lasta kasutajatel ise valida, mida nad tahavad näha ning maksta ainult selle eest (erinevalt teistest teenustest nagu Netflix ja Hulu).

Funktsionaalsuse loetelu prioriteedi järjekorras:
v0.1 Konto loomine ja sisse logimine
v0.2 Videote listide loomine
v0.3 Videote näitamine piiratud kasutajaskonnale


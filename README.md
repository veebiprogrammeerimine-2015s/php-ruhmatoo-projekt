# Noorte Tööbörs
* Liikmed: Rauno Kosula

### Eesmärk
1. Leida esmase töökogemuse võimalus noortele
1. Anda oma panus, noorte tööpuuduse vähendamiseks
1. Kogemuse omandamine uutes valdkondades

### Kirjeldus
* Nüüdseks luua uuendatud lehekülg, kus noored saavad otsida hooajaks või pikemaks perspektiiviks endale tööd.
* Eeskuju:
	* www.ntb.ee
	* www.cv.ee
	* www.cvkeskus.ee

### Changelog
* Ei hakanud siia ümber copy-pastema, formaat oleks sassi läinud
	* https://docs.google.com/document/d/1vE8Hkn0aeqLXG5PnrJpyACgweiHNCH-bymycEYhxyuk/edit?usp=sharing

* Skeem
	* http://i.imgur.com/RB7Sw3Z.png

* Failipuu
	* mytree.txt
	* https://docs.google.com/document/d/1kT17wNZbDJnxAz58_1yZKWgibMEN_IpIFNHq21zSVEk/edit?usp=sharing

### Kokkuvõte
* Mida õppisid juurde? mis ebaõnnestus? mis oli keeruline? (kirjutab iga tiimi liige).
* Õppisin juurde päris paljusi asju, toon välja need, mis pähe tulevad:
	* Uute failide loomine läbi koodi (fopen)
	* Meilide saatmine
	* Küpsiste kasutamine
	* Document_root ja mõned teisedki SERVER funktsioonid
	* Parooli muutmine/taastamine
* Ebaõnnestus:
	* Tõenäoliselt ebaõnnestus enda eesmärgini jõudmine, soov oli 0.8ni jõuda ja midagi luua seal, kuid 0.7 rabas jalust.
* Keeruline:
	* Kõige keerulisem ehk oli CV loomine. Kui nüüd hakkasin looma seda, mõtlesin, et tegemist saab suht lihtsa asjaga olema, siis lõpuks ma hakkasin enda sõnu sööma ja tegelesin sellega tunduvalt kauem kui oleksin pidanud. Takistuseks oli just lehe pidev refreshi vajamine, et muutuja saaks kuhugi minna ja lõpuks sai lihtsalt kolmandat teed pidi mindud ja leitud tegelikult kõige optimaalsem lahendus.
	* Meeletult palju nägin ka vaeva sellega, et kui lükkasin kõik failid kaustadesse, et ta hakkaks suunama edaspidi õigetesse kohtadesse.

### Mis kõike tegin?
Alustatud sai logimise/registeerimise süsteemidega. Seejärel leidsin, et kõige targem oleks alustada just tööandja poolsete funktsioonidega. Enamjaolt mässasin andmebaasi päringutega. Tööandja peab algselt täitma profiilis ära enda firma kontaktandmed ning edasipidi ta neid enam sisestama ei pea. Töölisamisel määrab ta need automaatselt paika. Üksjagu sai vaeva nähtud ka sellega, et kui tööandja peaks enda firma nime muutma, siis ta vahetaks ka kõigil töödel automaatselt nimed ära. Lahenduseni jõudsin niimodi, et lükkasin alguses Foreign key checki välja, muudan andmed kahes tabelis ära ning lükkan foreign key checki taas peale. Sai ka vaevanähtud dropdownidega, et nad oleks dünaamilised, kuid kuna ma ei soovinud seda, et ta hakkaks igakord refreshima lehte siis sai lähenetud javascriptiga. Paraku minu teadmised javascripti osas head pole, õnneks Romil aitas hädast välja. Töödele on määratud ka aktiivne/ebaaktiivne staatus, et tööandja saaks näiteks pisut hiljem samuti sama kuulutust kasutada, ilma, et peaks seda uuesti kirjutama. Seejärel sai mindud admin funktsioonide kallale, et ei peaks koguaeg andmebaasile ligi tikkuma vaid vajalikud muudatused saaks teha otse veebilehel. Admin saab näiteks töid lisada ükskõik millisele ettevõttele. See võtab omakorda ettevõtte kontaktandmed ning määrab need tööle. Viimasena sai pööratud tähelepanu just tavakasutajatele, alustasin parooli taastamisega, mis osutus väga põnevaks väljakutseks. Vastavalt ajale loob ta random hashi ning saadab selle random hashi meilile. Kasutades seda random hashi koos emailiga, siis kontrollitakse, kas selline päring on andmebaasis olemas ning ega see poleks vanem kui 7 päeva. Kui on olemas, siis määrab uue parooli, mis tuli samuti meilile. Järgmine põnev väljakutse oli parooli vahetamine, kuid kuna parooli taastamine oli juba tehtud, siis oli juba korralik põhi all ning sai suhteliselt kiirelt lahendatud. Suurt midagi see ei tee, kontrollib esmalt vana parooli ning seejärel teeb javascript veel oma töö, kas uus ja korda uut klapivad. Tõenäoliselt kõige raskemaks osutus CVde loomine, kus ma alguses plaanisin kasutada bootstrapi "collapse" võimalust, kuid kuna see hakkas meeletult pikaks venima siis jätsin selle sinnapaika. Üksjagu sai disaini osas maadeldud ning lõpuks lükkasin kõik tabelisse, et hiljem tegeleda sellega. Andmete sisestamine töötab seal läbi modali ning lükkab igakord uue andme koheselt andmebaasi sisse. Seejärel sai loodud CV saatmine, see nõudis, et ma teen tööde lisamine pisut ümber ning looksin igale tööle taas omakorda lehe. Seejärel saab tööandja vaadata saadetud CVsi (PDF formaadis) ning kirjutada, kas sobis või ei, mis tulevikus saadab ka meili kirja. Tegeletud sai ka küpsistega, mis nõudis samuti üksjagu vaeva, kogu aja nõudmise põhjus oli see, et küpsiste kontroll oli enne session_starti, muidu suhteliselt tavaline andmebaasi sisestamine/kontroll. Samuti parooli taastamine salvestab tabelisse nii päringu esitaja kui ka kasutaja IP aadressi. 

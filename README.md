# NO PLAGIARISM
Merit Paist, Martti Naaber

## Eesmärk
- Luua vabakutseliste ajakirjanike andmebaasi
- Miks? Sest Eestis ei ole vabakutseliste ajakirjanike andmebaasi
- Viia omavahel kokku vabakutselised ajakirjanikud ja potentsiaalsed tööandjad üksikute projektide raames
- Tööandja sisestab projekti (nt uudislugu, pressiteade) ja ajakirjanikud saavad valida projekte, millele pakkumisi teha.
- Tööandjal on võimalik valida pakkumiste hulgast välja parim pakkumimine

## Kirjeldus
- Sihtgrupiks ettevõtted, kes vajavad kirjutamisteenust, ja vabakutselised ajakirjanikud
- http://www.designcrowd.com/

## Lehe tööpõhimõte
```
|header.php
|---menu.php
|   |---home.php
|   |---login.php-------|
|   |---create_user.php |
|						|
|						|
|						|---login.php
|						  	|   (Ettevõte logib sisse)
|						  	|---data.php (sisestab tööpakkumise)
|						  	|---table.php (näeb oma sisestatuid pakkumisi)
|						  	|---edit.php (saab muuta neid pakkumisi, kus ei ole tehtud ajakirjaniku pakkumist)
|						  	|---offers.php (saab vaadata ajakirjanike pakkumisi oma tööpakkumistele)
|						  	|	|---feedback.php (saab anda ajakirjanikule tagasisidet)
|						  	|
|						  	|	(Ajakirjanik logib sisse)
|						  	|---table.php (näeb kõiki tööpakkumisi ja saab teha oma pakkumise)
|						  	|---offers.php (saab näha oma pakkumisi)
|						  	|	|---feedback.php (saab anda ettevõttele tagasisidet)
|						  	|
|						  	|	(Admin logib sisse)
|						  	|---admin.php
|								|---table.php
|							    |---offers.php
|							    |---history.php
|footer.php
```

## Failipuu
```
|pages
|---menu.php
|---home.php
|---login.php
|---create_user.php
|---data.php
|---table.php
|---edit.php
|---offers.php
|---feedback 
|---history.php
|---admin.php
|
|classes
|---User.class.php
|---OfferManager.class.php
|
|header.php
|footer.php
|functions.php
```

## Andmebaas


## Kokkuvõte
- Mida õppisid juurde?
- Mis ebaõnnestus?
- Mis oli keeruline?



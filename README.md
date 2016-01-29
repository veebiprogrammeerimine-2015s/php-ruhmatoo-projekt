# Riiulifirma portfoolio leht


1. **Tööst**
    * Rühma liikmed: Richard Aasa;
    * Eesmärk: luua portfoolio leht n.ö ühe mehe riiulifirmadele;
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
        * V0.1 – Üldine lehekülg valmis, tuleb tabeleid integreerida.



    **kokkuvõte: mida õppisid juurde? mis ebaõnnestus? mis oli keeruline? (kirjutab iga tiimi liige).**

	**Richard Aasa:**

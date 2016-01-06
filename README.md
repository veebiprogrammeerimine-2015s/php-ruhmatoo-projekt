**Hinda minu professorit**



**Rühma liikmete nimed:**
Karl Grossberg
Rauno Kosula
Raiko Lepik


**Eesmärgid:**
Anda tagasisidet Õppejõududele
Saada tagasisidet Õpilastelt (Õppejõµud)
Õpilane teab, kas võtta seda ainet

**Kirjeldus:**
Põhineb ratemyproffessori põhjal
Rate my teacher
Sihtrühm : Eesti Üliõpilased



**Funktsionaalsus:**
Eraldi kasutajad Õppejõule ja Üliõpilastele
Õpilane saab lisada Õppejõu, keda hinnata


**Andmebaas:**
* procommet
** id, pro_id, user_id, comment, accepted, inserted, deleted
* professors
** id, userid, firstname, lastname, school
* ratingpro
** id, userid, profid, helpful, clarity, examgrade, classrate
* schools
** id, school
* usergroups
** id, name
* users
** id, code, email, password, firstname, lastname, school, usergroup, inserted

����php-ruhmatoo-projekt
    �   disain.css
    �   footer.php
    �   functions.php
    �   header.php
    �   index.php
    �   rate.class.php
    �   README.md
    �   user.class.php
    �   
    ����fail
    �       file.php
    �       
    ����page
    �       addprof.php
    �       comments.php
    �       login.php
    �       moderate.php
    �       professors.php
    �       profile.php
    �       rate.php
    �       rate_points.php
    �       register.php
    �       registerpage.php
    �       
    ����prof
            7.php
            professor.php

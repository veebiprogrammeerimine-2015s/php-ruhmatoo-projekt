<?php

namespace App;

/**
 * @author Merilin Takk
 *
 * See on põhiline klass mis kõiki asju jooksutab
 */
class App {

    public $mysqlUser = 'root';
    public $mysqlPassword = '';
    public $mysqlDatabase = 'kaubamaja';
    public $mysqlHost = 'localhost';
    /**
     * @var \PDO
     */
    public $pdo;

    function __construct() {
        //Alustame sessioniga
        session_start();
        //loome PDO ühenduse andmebaasiga suhtlemiseks
        $this->pdo = new \PDO("mysql:host=" . $this->mysqlHost . ';dbname='
            . $this->mysqlDatabase, $this->mysqlUser, $this->mysqlPassword);

    }

    /**
     * $_REQUEST parameetrid peaks minema $input sisse käivitamisel
     *
     * @param $input
     */
    function run($input) {
        $page = isset($input['page']) ? $input['page'] : 'index';
        if (in_array($page, ['login', 'logout', 'index', 'shops'])) {
            echo $this->loadPage($page, $input);
        } else {
            echo "<h2>Page not found</h2>";
        }
    }

    /**
     * Laadi leht
     * Lehe laadimine käib nime järgi
     *
     * @param $page
     */
    function loadPage($page, $input) {
        $dir = __DIR__ . '/View/';
        $file = $dir . str_replace(['..', '/', '\\'], '', $page) . '.php';
        $output = null;
        //Eemaldame punktid ja kaldkriipsud sest, et neid ei saa nimes olla.
        if (file_exists($file)) {
            ob_start();
            //Teeme muutujad kättesaadavaks vaatele
            extract($input);
            include($file);
            $output = ob_get_contents();
            ob_end_clean();
        }

        return $output;
    }
}

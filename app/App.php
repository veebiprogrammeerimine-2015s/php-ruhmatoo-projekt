<?php

namespace App;

/**
 * @author Merilin Takk, Henrik Romanenkov
 *
 * See on põhiline klass mis kõiki asju jooksutab
 */
class App {

    public $mysqlUser = '';
    public $mysqlPassword = '';
    public $mysqlDatabase = '';
    public $mysqlHost = '';
    /**
     * @var \PDO
     */
    public $pdo;

    function __construct($config) {
        $this->mysqlUser = $config['mysqlUser'];
        $this->mysqlPassword = $config['mysqlPassword'];
        $this->mysqlDatabase = $config['mysqlDatabase'];
        $this->mysqlHost = $config['mysqlHost'];

        //Alustame sessioniga
        session_start();
        //loome PDO ühenduse andmebaasiga suhtlemiseks
        $this->pdo = new \PDO("mysql:host=" . $this->mysqlHost . ';dbname='
            . $this->mysqlDatabase, $this->mysqlUser, $this->mysqlPassword);
        //Selleks, et nimed kuvaksid UTF8 kodeeringus
        $this->pdo->query('SET NAMES UTF8');

    }

    /**
     * $_REQUEST parameetrid peaks minema $input sisse käivitamisel
     *
     * @param $input
     */
    function run($input) {
        $page = isset($input['page']) ? $input['page'] : 'index';
        if (in_array($page, ['login', 'logout', 'index', 'shops', 'data'])) {
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
<?php

namespace App;

/**
 * @author Merilin Takk
 *
 * See on põhiline klass mis kõiki asju jooksutab
 */
class App {
    /**
     * $_REQUEST parameetrid peaks minema $input sisse käivitamisel
     *
     * @param $input
     */
    public function run($input) {
        $page = isset($input['page']);
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
    public function loadPage($page, $input) {
        ob_start();
        $dir = __DIR__ . '/View/';
        $file = $dir . str_replace(['..', '/', '\\'], '', $page) . '.php';
        //Eemaldame punktid ja kaldkriipsud sest, et neid ei saa nimes olla.
        if (file_exists($file)) {
            //Teeme muutujad kättesaadavaks vaatele
            extract($input);
            include($file);
        }
        return ob_get_clean();
    }
}

<?php
namespace App\Controller;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use DataBase\Connection;
use Carbon\Carbon;

class BaseController{
    protected $db;
    public static $carb;

    public function __construct()
    {
        $this->db = new Connection();

    }

    public static function Carbonated(){
        self::$carb = Carbon::now()->setTimezone('Europe/Helsinki');
        return self::$carb;
    }

    public function render($templateName, array $parameters = array())
    {
        $templateName = !empty($templateName) ? $templateName : 'error404';
        $twig = new Environment(new FilesystemLoader('../src/views'), array('autoescape' => false));
        echo $twig->render($templateName.'.php', $parameters);
    }
    public function error($templateName, array $parameters = array())
    {
        $twig = new Environment(new FilesystemLoader('../src/views'), array('autoescape' => false));
        echo $twig->render('error404.php', $parameters);
    }
     public function getData($string){


        $data = [];
        foreach ($this->db->openConnection()->query($string) as $row) {
            $data[] = $row;
        }
        $this->db->closeConnection();
        return $data;
    }
}




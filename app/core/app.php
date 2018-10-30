<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2/9/2018
 * Time: 12:23 PM
 */



class App
{

/* url route like this
 *
 * domainName/controllerName/methodName/param1/param2/...
 *
 */



//    default controller name
    protected $controller = 'homeController';

//    default method name
    protected $method = 'index';

//    parameter send from client
    protected $params = [];


    public function __construct()
    {
        $url = $this->parseUrl();

        if (file_exists('../app/controllers/'.$url[0].'Controller.php'))

        {

            //concat controller to last of controller name
            $this->controller = $url[0].'Controller';
            unset($url[0]);


        }



        require_once '../app/controllers/'.$this->controller.'.php';

        $this->controller = new $this->controller();

        if (isset($url[1]))
        {

            if (method_exists($this->controller,$url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }

        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller,$this->method],$this->params);


    }




    protected function parseUrl()
    {


        if (isset($_GET['url']))
        {
            return explode("/" , filter_var(rtrim($_GET["url"],"/"),FILTER_SANITIZE_URL));

        }



    }






}



?>
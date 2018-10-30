<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 2/9/2018
 * Time: 5:43 PM
 */



class Controller
{







/* require mode
*
*
 * @param $model : model name
 * model name should be lowercase
*/
    protected function model($model)
    {
        require_once '../app/models/'.$model.'.php';
        return new $model();
    }


    /*render view
     * @param $view : view name
     * view name should be the same
     */

    protected function view($view,$data=[])
    {

        require_once '../app/views/templates/header.php';

        require_once '../app/views/'.$view.'.php';

        require_once '../app/views/templates/footer.php';


    }





}
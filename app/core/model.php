<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 9/17/2018
 * Time: 8:47 PM
 */

abstract class Model
{



    private $db;


    public function __construct()
    {

        $this->db = DataBase::getInstance()->getConnection();

    }





    public function getDb()
    {
        return $this->db;
    }




}
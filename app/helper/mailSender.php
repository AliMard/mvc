<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 9/15/2018
 * Time: 12:04 PM
 */

use PHPMailer\PHPMailer\PHPMailer;

class mailSender
{



    private $mailInst;


    public function __construct()
    {
        $this->mailInst = new PHPMailer();
        $this->mailInst->CharSet = 'UTF-8';
        $this->mailInst->isSMTP();
        $this->mailInst->Host = 'smtp address';
        $this->mailInst->Port = 'smtp port [Integer]';
        $this->mailInst->SMTPAuth =true;
        $this->mailInst->Username = 'Enter username';
        $this->mailInst->Password ='Enter password';


    }






    public function sendMail($to,$subject="", $msg="")
    {


        try {
            $this->mailInst->setFrom("Mail send from","name" );
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            return false;
        }

        $this->mailInst->addAddress($to);
        $this->mailInst->Subject =$subject;
        $this->mailInst->msgHTML($msg);

        try {
            if ($this->mailInst->send())
                return true;

        }catch (Exception $e) {
            return false;
        }



        return false;

    }






}
<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 5/3/2018
 * Time: 2:47 PM
 */

use  Emarref\Jwt\Claim;


class Validate
{


    /**
     * this variable use to jwt token
     */
    public static $STATUS=0;
    public static $TOKEN=0;
    public static $DATA=array();
    public static $INFORMATION=0;


    /**
     * Validate::clearInputs
     * clear invalid character for do process
     *
     *
     * @param $param string input from client
     * @return null if param empty|string clear input from invalid character
     *
     */
    public static function clearInputs($param)
    {

        return (!empty($param))? trim(htmlentities(addslashes($param))) : null;


    }


    /**
     * Validate::clearScreenText
     * clear invalid character for show to client
     *
     * @param $param input from database
     * @return null if param empty|string clear input from invalid character
     */

    public static function clearScreenText($param)
    {
        return (!empty($param))? stripslashes(filter_var($param,FILTER_SANITIZE_FULL_SPECIAL_CHARS)) : null;
    }


    /**
     * Validate::checkRequest
     *
     * check the accuracy of the request sender`s address
     *
     *
     *
     * @param null $referer string refer url
     * @return bool
     */

    public static function checkRequest($referer=null){

            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER["HTTP_REFERER"]==BASE_URL.$referer)
                return true;


        return false;
    }


    public static function hashData($value,$key)
    {
        if (!empty($value))
        {
            return base64_encode(sha1(md5(sha1($value).$key).$key));
        }

        return null;
    }



  public static  function isColor($colorCode) {
        $colorCode = ltrim($colorCode, '#');

        if (
            ctype_xdigit($colorCode) &&
            (strlen($colorCode) == 6 || strlen($colorCode) == 3))
            return true;

         return false;
    }


    public static function isImg($name)
    {
        $rex="([^\s]+(?=\.(jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF)))";

        if (preg_match($rex,$name))
            return true;

        return false;

    }



    public static function isMobile($mobile)
    {
        $rex="(^(\+98|0)9\d{2}\d{3}\d{2}\d{2}$)";
        if (preg_match($rex,$mobile))
            return true;

        return false;
    }


    public static function isPhone($phone)
    {
        $rex="(^(\+98|0)[1-8]\d{2}\d{3}\d{2}\d{2}$)";
        if (preg_match($rex,$phone))
            return true;

        return false;
    }




  public static function convertNum($string) {
        $persinaDigits1= array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $persinaDigits2= array('٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠');
        $allPersianDigits=array_merge($persinaDigits1, $persinaDigits2);
        $replaces = array('0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9');
        return str_replace($allPersianDigits, $replaces , $string);
    }




    public static function isTime($time,$sec=false)
    {


        $rex="";
        if ($sec)
            $rex="(^\d{2}\:\d{2}\:\d{2}$)";
        else
            $rex="(^\d{2}\:\d{2}$)";

        if (preg_match($rex,$time))
            return true;
        return false;
    }



    public static function isDate($date)
    {
        $rex="(^\d{4}\/\d{2}\/\d{2}$)";
        if (preg_match($rex,$date))
            return true;
        return false;
    }


  public static function randomString($length) {
        $keys = array_merge(range(0,9), range('a', 'z'));

        $key = "";
        for($i=0; $i < $length; $i++) {
            $key .= $keys[mt_rand(0, count($keys) - 1)];
        }
        return $key;
    }



    public static function makeJwt($pClaim , $exp=60)
    {


        $exTime = $exp.' minute';



        $token = new Emarref\Jwt\Token();

        $token->addClaim(new Claim\Audience([JWT_AUDIENCE]));
        $token->addClaim(new Claim\Expiration( new DateTime($exTime)));
        $token->addClaim(new Claim\IssuedAt(new DateTime('now')));
        $token->addClaim(new Claim\Issuer(JWT_ISSUER));

        if (is_array($pClaim)){
            foreach ($pClaim as $key=>$value){
                $token->addClaim(new Claim\PublicClaim($value['name'],$value['value']));
            }
        }


        $jwt = new Emarref\Jwt\Jwt();

        $algorithm= new Emarref\Jwt\Algorithm\Hs512(JWT_ALGORITHM_KEY);
        $encryption = Emarref\Jwt\Encryption\Factory::create($algorithm);
        $serializedToken = $jwt->serialize($token,$encryption);

        return $serializedToken;

    }





    public static function jwtVerify($token)
    {


        $jwt = new Emarref\Jwt\Jwt();
        $algorithm = new Emarref\Jwt\Algorithm\Hs512(JWT_ALGORITHM_KEY);
        $encryption = Emarref\Jwt\Encryption\Factory::create($algorithm);

        $context = new Emarref\Jwt\Verification\Context($encryption);
        $context->setAudience(JWT_AUDIENCE);
        $context->setIssuer(JWT_ISSUER);

        try{

            $tk = $jwt->deserialize($token);

            if ($jwt->verify($tk,$context)){


                return true;
            }

        }catch (Exception $e){
            return false;
        }


        return false;

    }




    public static function jwtDecode($token)
    {


        $jwt = new Emarref\Jwt\Jwt();
        $algorithm = new Emarref\Jwt\Algorithm\Hs512(JWT_ALGORITHM_KEY);
        $encryption = Emarref\Jwt\Encryption\Factory::create($algorithm);

        $context = new Emarref\Jwt\Verification\Context($encryption);
        $context->setAudience(JWT_AUDIENCE);
        $context->setIssuer(JWT_ISSUER);

        try{

            $tk = $jwt->deserialize($token);

            if ($jwt->verify($tk,$context)){

                $payLoad = json_decode($tk->getPayload()->jsonSerialize(),true);


                return $payLoad;

            }

        }catch (Exception $e){
            return false;
        }


        return false;

    }


   public static function getResultArray()
   {

       return array(['status'=>self::$STATUS  , 'token'=>self::$TOKEN  , 'data'=>self::$DATA,
           'information'=>self::$INFORMATION]);

   }









}








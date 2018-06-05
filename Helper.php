<?php

class Helper
{
    public static function cleanData($data)
    {
        $data = trim($data);
        $data = htmlentities($data, ENT_QUOTES);
        return $data;
    }

    public static function checkData($name, $email)
    {
        $errortable = array();

        if(empty($name))
        {
            $errortable["naam"] = "Naam is niet ingevuld";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errortable["email"] = "E-mail is niet correct";
        }

        return $errortable;
    }

}
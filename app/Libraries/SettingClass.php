<?php
/**
 * Created by PhpStorm.
 * User: COMPUTER
 * Date: 5/18/2018
 * Time: 9:29 AM
 */

namespace App\Libraries;


use App\Setting;

class SettingClass
{
    protected static $_Settingvalue = null;
    protected static $_Settingdescription = null;

    protected static $_instanceValue = null;
    protected static $_instanceDescription = null;

    private function __construct($key)
    {
        self::${"_Setting" . $key} = Setting::pluck($key, 'data_key');
    }

    public static function getSetting($key){
        if(self::$_instanceValue === null)
            self::$_instanceValue = new self('value');

        return self::$_Settingvalue[$key];
    }

    public static function getSettingDescription($key){
        if(self::$_instanceDescription === null)
            self::$_instanceDescription = new self('description');

        return self::$_Settingdescription[$key];
    }
}
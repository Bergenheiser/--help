<?php

require_once __DIR__ . "/ModelUser.php";

class ControllerUser extends GenericController
{

    public static function welcome() {
        self::afficheVue([
            "pagetitle" => "Welcome !",
            "cheminVueBody" => "user/welcome.php",
        ]);
    }

    public static function honey() {
        // TODO


        self::afficheVue([
            "pagetitle" => "HoneyPot !",
            //"users" => ModelUser::selectAll(),
            "cheminVueBody" => "user/honey.php",
        ]);
    }

    public static function formSubmit() {
        self::afficheVue([
            "pagetitle" => "Submit !",
            "cheminVueBody" => "user/formSubmit.php",
        ]);
    }

}
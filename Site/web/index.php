<?php

require_once "../src/Controller/GenericController.php";
require_once "../src/Controller/ControllerUser.php";

$action = $_GET['action'] ?? "welcome";

$controller = $_GET['controller'] ?? "user";

$controllerClassName = "Controller" . ucfirst($controller);


if (class_exists($controllerClassName)) {
    if (in_array($action,get_class_methods($controllerClassName))){
        $controllerClassName::$action();
    } else {
        GenericController::error("Action inconnu !!");
    }
} else {
    GenericController::error("Controller inconnu !!");
}
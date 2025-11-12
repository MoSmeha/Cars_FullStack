<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ . "/../services/CarServices.php");
class CarController {

    function getCars(){
        global $connection;
            if(isset($_GET["id"])){
            $id = $_GET["id"];
            }else{
                $id=null;
            }
            echo CarService::getCars($connection,$id);
            
        }
}

$controller = new CarController();
$controller->getCars();
?>
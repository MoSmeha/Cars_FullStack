<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");

class CarController {

    function getCars(){
        global $connection;
        try {
            if(isset($_GET["id"])){
            $id = $_GET["id"];
            $car = Car::find($connection, $id);
            if(!$car){
            echo ResponseService::response(404, "No car found with this id");
            } else{
            echo ResponseService::response(200, $car->toArray());
            }

            return;
            }
            $allCars = Car::findAll($connection);
            $carList = [];
            foreach($allCars as $car){
                $carList[] = $car->toArray();
            }
            echo ResponseService::response(200, $carList);
            } catch(Exception $e) {
                echo 'Error in fetching Cars : ' .$e->getMessage();
            }
       
        // not allowed to write logic in my controller!!!

        return;
    }

    //try catch 

}
$controller = new CarController();
$controller->getCars();
?>
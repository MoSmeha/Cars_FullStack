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
        function createCar(){
        global $connection;
        $name  = $_GET['name']  ?? '';
        $color = $_GET['color'] ?? '';
        $year  = $_GET['year']  ?? '';
        if (!$name || !$color || !$year) {
        echo ResponseService::response(400, "Input all fields");
        return;
        }
        try {
            $car = [
                "name"  => $name,
                "color" => $color,
                "year"  => $year
            ];
            $created = Car::create($connection, $car);
            if (!$created) {
            echo ResponseService::response(500, "failed to save the car");
            return;
            }
            echo ResponseService::response(200, "car created successfully" . $created);
            } catch (Exception $e) {
            echo ResponseService::response(500, "error creating car: " . $e->getMessage());
        }
    }

    function updateCar(){
        global $connection;
        $id    = $_GET['id']    ?? '';
        $name  = $_GET['name']  ?? '';
        $color = $_GET['color'] ?? '';
        $year  = $_GET['year']  ?? '';
        if (!$id) {
            echo ResponseService::response(400, "ID required");
            return;
        }
        try {
            $data = [
                "name"  => $name,
                "color" => $color,
                "year"  => $year
            ];
            $updated = Car::update($connection, (int)$id, $data);
            if (!$updated) {
            echo ResponseService::response(500, "failed to update car");
            return;
            }
            echo ResponseService::response(200, "car updated successfully");
            } catch (Exception $e) {
            echo ResponseService::response(500, "error updating car: " . $e->getMessage());
        }
    }

    function deleteCar(){
        global $connection;
        $id = $_GET['id'] ?? '';
        if (!$id) {
        echo ResponseService::response(400, "car ID is required");
        return;
        }
        try {
            $deleted = Car::delete($connection, (int)$id);
            if (!$deleted) {
            echo ResponseService::response(500, "failed to delete car");
            return;
            }
            echo ResponseService::response(200, "car deleted successfully");
        } catch (Exception $e) {
            echo ResponseService::response(500, "error deleting car: " . $e->getMessage());
        }
    }
}

   

?>
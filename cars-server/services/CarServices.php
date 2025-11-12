<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/ResponseService.php"); 

class CarService {

    public static function getCars(mysqli $connection, int $id = null) {
        try {
                if ($id !== null) {
                $car = Car::find($connection, $id);
                if (!$car) {
                    return ResponseService::response(404, "No car found with this id");
                }
                return ResponseService::response(200, $car->toArray());
            }

            $allCars = Car::findAll($connection);
            $carList = [];
            foreach ($allCars as $car) {
                $carList[] = $car->toArray();
            }

            return ResponseService::response(200, $carList);

        } catch (Exception $e) {
            return ResponseService::response(500, "Error in fetching Cars: " . $e->getMessage());
        }
    }
}
?>

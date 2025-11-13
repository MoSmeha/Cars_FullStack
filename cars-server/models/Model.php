<?php
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $connection, string $id, string $primary_key = "id"){
        $sql = sprintf("SELECT * from %s WHERE %s = ?",
                       static::$table,
                       static::$primary_key);
                       //changed it back to access in update and delete

        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();               

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function findAll(mysqli $connection){
        $sql = sprintf("SELECT * from %s",
                       static::$table);

        $query = $connection->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        $cars = [];
        while($row = $result->fetch_assoc()){
            $cars[] = new static($row); 
        }

        return $cars;
    }
        public static function create(mysqli $connection, array $data){
        $columns = array_keys($data);
        $values = array_values($data);
        $placeholders = implode(',', array_fill(0, count($columns), '?'));

        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)",
                        static::$table,
                        implode(',', $columns),
                        $placeholders);
                   

        $query = $connection->prepare($sql);
        
        // All columns are varchar except id according to the migration you created so i won't check for float or other tpyes
        $types = str_repeat('s', count($values));

        // i get why it should be dynamic but we only check for the car user per the assignment so ill leave this here
        // $query->bind_param($types, $values[0], $values[1], $values[2]); 
        $query->bind_param($types, ...$values); // i get why it should be dynamic but we only check for the car user per the assignment
        return $query->execute();
    }

    public static function update(mysqli $connection, int $id, array $data){
        $columns = array_keys($data);
        $values = array_values($data);
        $set_clause = implode(' = ?, ', $columns) . ' = ?';

        $sql = sprintf("UPDATE %s SET %s WHERE %s = ?",
                    static::$table,
                    $set_clause,
                    static::$primary_key);
                

        $query = $connection->prepare($sql);
        $types = str_repeat('s', count($values)) . 'i';
        $values[] = $id;

        $query->bind_param($types, ...$values);
        return $query->execute();
    }

    public static function delete(mysqli $connection, int $id){
        $sql = sprintf("DELETE FROM %s WHERE %s = ?",
                        static::$table,
                        static::$primary_key);
                    
        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        return $query->execute();
        }
}
?>

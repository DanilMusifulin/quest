<?php

class Status
{
    // соединение с БД и таблицей "status"
    private $conn;
    private $table_name = "status";

    // свойства объекта
    public $id_status;
    public $status_name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // метод для получения всех статусов заданий
    public function read()
   {
    $query = "SELECT
                id_status, name_status
            FROM
                " . $this->table_name . "
            ORDER BY
                id_status";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
   }
}
?>

<?php

class User
{
    // подключение к базе данных и таблице "user"
    private $conn;
    private $table_name = "user";

    // свойства объекта
    public $id_user;
    public $name_user;
    public $balance;
    

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

  // метод получения всех пользователей
   function read()
   {
	// выбираем все записи
    	$query = "SELECT
        	id_user, name_user, balance
    	FROM
        	" . $this->table_name . "
    	ORDER BY
        	id_user DESC";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// выполняем запрос
    	$stmt->execute();
    	return $stmt;
   }
   

   // метод для создания пользователя
   function create()
   {
    	// запрос для вставки (создания) записей
    	$query = "INSERT INTO
            " . $this->table_name . "
        	SET
            name_user=:name_user, balance=:balance";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// очистка
    	$this->name_quest = htmlspecialchars(strip_tags($this->name_user));
    	$this->balance = htmlspecialchars(strip_tags($this->balance));
    	    	

    	// привязка значений
    	$stmt->bindParam(":name_user", $this->name_user);
    	$stmt->bindParam(":balance", $this->balance);

    	
    	
    	// выполняем запрос
    	if ($stmt->execute()) {
        	return true;
    	}
    	return false;
    }
  
 // метод для получения конкретного задания по ID
  function readOne()
  {
    // запрос для чтения одной записи 
    $query = "SELECT 
              id_user, name_user, balance
           FROM
            " . $this->table_name . " 
        WHERE
            id_user = ?
        LIMIT
            0,1";
     // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // привязываем id записи, который будет получен
    $stmt->bindParam(1, $this->id_user);

    // выполняем запрос
    $stmt->execute();

    // получаем извлеченную строку
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // установим значения свойств объекта
    $this->name_user = $row["name_user"];
    $this->balance = $row["balance"];

  } 
 
 // метод для обновления пользователя
  function update()
  {
    // запрос для обновления записи 
    $query = "UPDATE
            " . $this->table_name . "
        SET
            name_user = :name_user,
            balance = :balance
        WHERE
            id_user = :id_user";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->name_user = htmlspecialchars(strip_tags($this->name_user));
    $this->balance = htmlspecialchars(strip_tags($this->balance));
    $this->id_user = htmlspecialchars(strip_tags($this->id_user));

    // привязываем значения
    $stmt->bindParam(":name_user", $this->name_user);
    $stmt->bindParam(":balance", $this->balance);
    $stmt->bindParam(":id_user", $this->id_user);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
  }
  
 // метод для удаления задания
  function delete()
  {
    // запрос для удаления записи 
    $query = "DELETE FROM " . $this->table_name . " WHERE id_user = ?";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->id_quest = htmlspecialchars(strip_tags($this->id_user));

    // привязываем id записи для удаления
    $stmt->bindParam(1, $this->id_user);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
  } 

  // метод для поиска по ФИО
  function search($keywords)
  {
    // поиск записей (заданий) по "названию задания", "описания задания"
    $query = "SELECT
            id_user, name_user, balance
        FROM
            " . $this->table_name . " 
        WHERE
            name_user LIKE ? 
        ORDER BY
            id_user DESC";

  // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $keywords = htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    // привязка
    $stmt->bindParam(1, $keywords);
    // выполняем запрос
    $stmt->execute();

    return $stmt;
  }
 

  //  возвращает кол-во пользователей
  public function count()
  {
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row["total_rows"];
  }
}
?>

<?php

class Quest
{
    // подключение к базе данных и таблице "quest"
    private $conn;
    private $table_name = "quest";

    // свойства объекта
    public $id_quest;
    public $name_quest;
    public $description;
    public $created;
    public $cost;
    

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

  // метод для просмотра заданий (описан)
   function read()
   {
	// выбираем все записи
    	$query = "SELECT
        	id_quest, name_quest, description, created, cost
    	FROM
        	" . $this->table_name . "
    	ORDER BY
        	created DESC";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// выполняем запрос
    	$stmt->execute();
    	return $stmt;
   }
   

   // метод для создания задания (+)
   function create()
   {
    	// запрос для вставки (создания) записей
    	$query = "INSERT INTO
            " . $this->table_name . "
        	SET
            name_quest=:name_quest, description=:description, description=:description, created=:created, cost=:cost";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// очистка
    	$this->name_quest = htmlspecialchars(strip_tags($this->name_quest));
    	$this->description = htmlspecialchars(strip_tags($this->description));
    	$this->created = htmlspecialchars(strip_tags($this->created));
    	$this->cost = htmlspecialchars(strip_tags($this->description));
    	    	

    	// привязка значений
    	$stmt->bindParam(":name_quest", $this->name_quest);
    	$stmt->bindParam(":description", $this->description);
    	$stmt->bindParam(":created", $this->created);
    	$stmt->bindParam(":cost", $this->cost);
    	
    	
    	// выполняем запрос
    	if ($stmt->execute()) {
        	return true;
    	}
    	return false;
    }
  
 // метод для получения конкретного задания по ID (+)
  function readOne()
  {
    // запрос для чтения одной записи 
    $query = "SELECT id_quest, name_quest, description, created, cost
           FROM
            " . $this->table_name . " 
        WHERE
            id_quest = ?
        LIMIT
            0,1";
     // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // привязываем id, который будет получен
    $stmt->bindParam(1, $this->id);

    // выполняем запрос
    $stmt->execute();

    // получаем извлеченную строку
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // установим значения свойств объекта
    $this->name_quest = $row["name_quest"];
    $this->description = $row["description"];
    $this->created = $row["created"];
    $this->cost = $row["cost"];
  } 
 
 // метод для обновления задания (+)
  function update()
  {
    // запрос для обновления записи 
    $query = "UPDATE
            " . $this->table_name . "
        SET
            name_quest = :name_quest,
            description = :description,
            created = :created,
            cost = :cost
        WHERE
            id_quest = :id_quest";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->name_quest = htmlspecialchars(strip_tags($this->name_quest));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->created = htmlspecialchars(strip_tags($this->created));
    $this->cost = htmlspecialchars(strip_tags($this->cost));
    $this->id_quest = htmlspecialchars(strip_tags($this->id_quest));

    // привязываем значения
    $stmt->bindParam(":name_quest", $this->name_quest);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":created", $this->created);
    $stmt->bindParam(":cost", $this->cost);
    $stmt->bindParam(":id_quest", $this->id_quest);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
  }
  
 // метод для удаления задания (+)
  function delete()
  {
    // запрос для удаления записи 
    $query = "DELETE FROM " . $this->table_name . " WHERE id_quest = ?";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->id_quest = htmlspecialchars(strip_tags($this->id_quest));

    // привязываем id записи для удаления
    $stmt->bindParam(1, $this->id_quest);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
  } 

  // метод для поиска задания (+)
  function search($keywords)
  {
    // поиск записей (заданий) по "названию задания", "описания задания"
    $query = "SELECT
            id_quest, name_quest, description, created, cost
        FROM
            " . $this->table_name . " 
        WHERE
            name_quest LIKE ? OR description LIKE ?
        ORDER BY
            created DESC";

  // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $keywords = htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    // привязка
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    // выполняем запрос
    $stmt->execute();

    return $stmt;
  }
 

  //  возвращает кол-во заданий
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

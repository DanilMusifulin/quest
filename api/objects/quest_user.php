<?php

class Quest_user
{
    // подключение к базе данных и таблице "quest_user"
    private $conn;
    private $table_name = "quest_user";

    // свойства объекта
    public $id_quest;
    public $id_user;
    public $id_status;
    public $date_1;
    public $date_2;
    public $date_3;
    public $date_4;
    public $date_5;
    public $date_6;


    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

  // метод для просмотра истории выполнения заданий всех пользователей
   function read()
   {
	// выбираем все записи
    	$query = "SELECT
          id_quest, id_user, name_status, date_1, date_2, date_3, date_4, date_5, date_6, status.id_status
    	 FROM
        	" . $this->table_name . " , status
       WHERE quest_user.id_status = status.id_status
    	 ORDER BY
        	date_1 DESC";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// выполняем запрос
    	$stmt->execute();
    	return $stmt;
   }
  
  
  // метод для просмотра заданий на оплату (сигнализация об оплате)
   function necessary_to_pay()
   {
	// выбираем все записи
    	$query = "SELECT
          id_quest, id_user, name_status, date_1, date_2, date_3, date_4, date_5, date_6, status.id_status
    	 FROM
        	" . $this->table_name . " , status
       WHERE quest_user.id_status = status.id_status and status.id_status=5
    	 ORDER BY
        	date_1 DESC";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// выполняем запрос
    	$stmt->execute();
    	return $stmt;
    	
    	
    	
   } 
    
    // метод для назначения задания на пользователя
   function create()
   {
    	// запрос для вставки (создания) записей
    	$query = "INSERT INTO
            " . $this->table_name . "
        	SET
            id_quest=:id_quest, id_user=:id_user, id_status=1, date_1=:date_1";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// очистка
    	$this->id_quest = htmlspecialchars(strip_tags($this->id_quest));
    	$this->id_user = htmlspecialchars(strip_tags($this->id_user));
    	$this->date_1 = htmlspecialchars(strip_tags($this->date_1));

    	// привязка значений
    	$stmt->bindParam(":id_quest", $this-id_quest);
    	$stmt->bindParam(":id_user", $this->id_user);
    	$stmt->bindParam(":date_1", $this->date_1);

    	// выполняем запрос
    	if ($stmt->execute()) {
        	return true;
    	}
    	return false;
    }
    
   // метод для подтвержения пользователем начала выполнения задания
   function pick_up()
   {
    	// запрос для вставки (создания) записей
    	$query = "UPDATE
            " . $this->table_name . "
        	SET
            id_status=2, date_2=:date_2
          where  id_quest=:id_quest and  id_user=:id_user";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// очистка
    	$this->id_quest = htmlspecialchars(strip_tags($this->id_quest));
    	$this->id_user = htmlspecialchars(strip_tags($this->id_user));
    	$this->date_2 = htmlspecialchars(strip_tags($this->date_2));

    	// привязка значений
    	$stmt->bindParam(":id_quest", $this-id_quest);
    	$stmt->bindParam(":id_user", $this->id_user);
    	$stmt->bindParam(":date_2", $this->date_2);

    	// выполняем запрос
    	if ($stmt->execute()) {
        	return true;
    	}
    	return false;
    }
    
    // метод для подтвержения выполнения звдвния пользователем
   function done()
   {
    	// запрос для вставки (создания) записей
    	$query = "UPDATE
            " . $this->table_name . "
        	SET
            id_status=3, date_3=:date_3
          where  id_quest=:id_quest and  id_user=:id_user";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// очистка
    	$this->id_quest = htmlspecialchars(strip_tags($this->id_quest));
    	$this->id_user = htmlspecialchars(strip_tags($this->id_user));
    	$this->date_3 = htmlspecialchars(strip_tags($this->date_3));

    	// привязка значений
    	$stmt->bindParam(":id_quest", $this-id_quest);
    	$stmt->bindParam(":id_user", $this->id_user);
    	$stmt->bindParam(":date_3", $this->date_3);

    	// выполняем запрос
    	if ($stmt->execute()) {
        	return true;
    	}
    	return false;
    }
    
    
   // метод для подтверждения начала контроля задания
   function taken_under_control()
   {
    	// запрос для вставки (создания) записей
    	$query = "UPDATE
            " . $this->table_name . "
        	SET
            id_status=4, date_4=:date_4
          where  id_quest=:id_quest and  id_user=:id_user";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// очистка
    	$this->id_quest = htmlspecialchars(strip_tags($this->id_quest));
    	$this->id_user = htmlspecialchars(strip_tags($this->id_user));
    	$this->date_4 = htmlspecialchars(strip_tags($this->date_4));

    	// привязка значений
    	$stmt->bindParam(":id_quest", $this-id_quest);
    	$stmt->bindParam(":id_user", $this->id_user);
    	$stmt->bindParam(":date_4", $this->date_4);

    	// выполняем запрос
    	if ($stmt->execute()) {
        	return true;
    	}
    	return false;
    }
    
    // метод для подтверждения окончания контроля задания
   function control_passed()
   {
    	// запрос для вставки (создания) записей
    	$query = "UPDATE
            " . $this->table_name . "
        	SET
            id_quest=:id_quest, id_user=:id_user, id_status=5, date_5=:date_5";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// очистка
    	$this->id_quest = htmlspecialchars(strip_tags($this->id_quest));
    	$this->id_user = htmlspecialchars(strip_tags($this->id_user));
    	$this->date_3 = htmlspecialchars(strip_tags($this->date_5));

    	// привязка значений
    	$stmt->bindParam(":id_quest", $this-id_quest);
    	$stmt->bindParam(":id_user", $this->id_user);
    	$stmt->bindParam(":date_5", $this->date_5);

    	// выполняем запрос
    	if ($stmt->execute()) {
        	return true;
    	}
    	return false;
    }
    
   // метод для совершения оплаты
   function control_pay()
   {
    	// запрос для вставки (создания) записей
    	$query = "UPDATE
            " . $this->table_name . "
        	SET
             id_status=6, date_6=:date_6 
          where  id_quest=:id_quest and  id_user=:id_user;
         
         UPDATE 
            user
         SET 
             balance=balance + (SELECT cost from quest where id_quest=:id_quest)
	 WHERE id_user=:id_user";

    	// подготовка запроса
    	$stmt = $this->conn->prepare($query);

    	// очистка
    	$this->id_quest = htmlspecialchars(strip_tags($this->id_quest));
    	$this->id_user = htmlspecialchars(strip_tags($this->id_user));
    	$this->date_3 = htmlspecialchars(strip_tags($this->date_5));

    	// привязка значений
    	$stmt->bindParam(":id_quest", $this-id_quest);
    	$stmt->bindParam(":id_user", $this->id_user);
    	$stmt->bindParam(":date_6", $this->date_6);

    	// выполняем запрос
    	if ($stmt->execute()) {
        	return true;
    	}
    	return false;
    }  
    
    
  
  // метод для просмотра истории выполнения работ и баланс по конкретному пользователю
  function readOne()
  {
    // запрос для чтения одной записи 
    $query = "SELECT 
                name_user, name_quest, name_status, date_1, date_2, date_3, date_4, date_5, date_6, cost
              FROM 
                " . $this->table_name . ", user, quest,status
              WHERE 
                    quest_user.id_user = user.id_user
                    AND quest_user.id_quest = quest.id_quest
                    AND quest_user.id_status = status.id_status
                    AND quest_user.id_user =?
              UNION ALL
              SELECT 
                    'Баланс', '', '', '', '', '', '', '', '', SUM( cost )
              FROM 
                  quest_user, user, quest,status
              WHERE 
                  quest_user.id_user = user.id_user
                  AND quest_user.id_quest = quest.id_quest
                  AND quest_user.id_status = status.id_status
                  AND quest_user.id_user =?
                  AND quest_user.id_status =6";
     // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // привязываем id пользователя
    $stmt->bindParam(1, $this->id_user);

    // выполняем запрос
    $stmt->execute();

    // получаем извлеченную строку
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // установим значения свойств объекта
    $this->name_user = $row["name_user"];
    $this->name_quest = $row["name_quest"];
    $this->name_status = $row["name_status"];
    $this->date_1 = $row["date_1"];
    $this->date_2 = $row["date_2"];
    $this->date_3 = $row["date_3"];
    $this->date_4 = $row["date_4"];
    $this->date_5 = $row["date_5"];
    $this->date_6 = $row["date_6"];
    $this->cost = $row["cost"];
  } 
 
 
 // метод для удаления задания пользователя
  function delete()
  {
    // запрос для удаления записи 
    $query = "DELETE FROM " . $this->table_name . " WHERE id_quest = ? and id_user= ?";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->id_quest = htmlspecialchars(strip_tags($this->id_quest));
    $this->id_user = htmlspecialchars(strip_tags($this->id_user));

    // привязываем id записи для удаления
    $stmt->bindParam(1, $this->id_quest);
    $stmt->bindParam(2, $this->id_user);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
  } 

}
?>

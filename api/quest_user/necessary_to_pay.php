<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once "../config/database.php";
include_once "../objects/quest_user.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$quest_user = new Quest_user($db);
 
// запрашиваем товары
$stmt = $quest_user->necessary_to_pay();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив 
    $quest_users_arr = array();
    $quest_users_arr["records"] = array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $quest_user_item = array(
            "id_quest" => $id_quest,
            "id_user" => $id_user,
            "name_status" => $name_status,
	    "date_1" => $date_1,
	    "date_2" => $date_2,
            "date_3" => $date_3,
	    "date_4" => $date_4,
            "date_5" => $date_5,
            "date_6" => $date_6,
            "status.id_status" => $status.id_status


        );
        array_push($quest_users_arr["records"], $quest_user_item);
    }

    // устанавливаем код ответа - 200 OK
    //http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode($quest_users_arr);
}

// "задания не найдены" 
else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что задания не найдены
    echo json_encode(array("message" => "Задания не найдены."), JSON_UNESCAPED_UNICODE);
}
?>

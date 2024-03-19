<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
include_once "../config/database.php";
include_once "../objects/quest_user.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$quest_user = new quest_user($db);

// установим свойство ID записи для чтения
$quest_user->id_user = isset($_GET["id_user"]) ? $_GET["id_user"] : die();


// получим детали 
$quest_user->readOne();

if ($quest_user->name != null) {

    // создание массива
    $quest_user_arr = array(
        "name_user" =>  $quest_user->name_user,
        "name_quest" => $quest_user->name_quest,
        "name_status" => $quest_user->name_status,
	"date_1" => $date_1,
	"date_2" => $date_2,
        "date_3" => $date_3,
	"date_4" => $date_4,
        "date_5" => $date_5,
        "date_6" => $date_6,
        "cost" => $cost
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($quest_user_arr);
} else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой задания не существует
    echo json_encode(array("message" => "Задания не существует"), JSON_UNESCAPED_UNICODE);
}
?>

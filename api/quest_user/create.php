<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request_usered-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта 
include_once "../objects/quest_user.php";
$database = new Database();
$db = $database->getConnection();
$quest_user = new Quest_user($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты
if (
    !empty($data->id_quest) &&
    !empty($data->id_user) 
) {
    // устанавливаем значения свойств товара
    $quest_user->id_quest = $data->id_quest;
    $quest_user->id_user = $data->id_user;
    $quest_user->date_1 = date("Y-m-d H:i:s");


    // создание задания
    if ($quest_user->create()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Задание было создано"), JSON_UNESCAPED_UNICODE);
    }
    // если не удается создать задание, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно создать задание."), JSON_UNESCAPED_UNICODE);
    }
}
// сообщим пользователю что данные неполные
else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать задание. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>

<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом quest
include_once "../config/database.php";
include_once "../objects/quest.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$quest = new Quest($db);

// получаем id товара для редактирования
$data = json_decode(file_get_contents("php://input"));

// установим id свойства товара для редактирования
$quest->id_quest = $data->id_quest;

// установим значения свойств 
$quest->name_quest = $data->name_quest;
$quest->description = $data->description;
$quest->created = $data->created;
$quest->cost = $data->cost;

// обновление 
if ($quest->update()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Задание было обновлёно"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить задание, сообщим пользователю
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить задание"), JSON_UNESCAPED_UNICODE);
}
?>

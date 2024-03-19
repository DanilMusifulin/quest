<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение необходимых файлов
include_once "../config/core.php";
include_once "../config/database.php";
include_once "../objects/quest.php";

// создание подключения к БД
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$quest = new Quest($db);

// получаем ключевые слова
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

// запрос 
$stmt = $quest->search($keywords);
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей
if ($num > 0) {
    // массив 
    $quests_arr = array();
    $quests_arr["records"] = array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // извлечём строку
        extract($row);
        $quest_item = array(
            "id_quest" => $id_quest,
            "name_quest" => $name_quest,
            "description" => html_entity_decode($description),
            "created" => $created,
            "cost" => $cost
        );
        array_push($quests_arr["records"], $quest_item);
    }
    // код ответа - 200 OK
    http_response_code(200);

    // покажем 
    echo json_encode($quests_arr);
} else {
 // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // скажем пользователю, что не найдены
    echo json_encode(array("message" => "Задания не найдены."), JSON_UNESCAPED_UNICODE);
}
?>

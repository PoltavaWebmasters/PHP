<?php
// Необходимые заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Подключение базы данных
include_once ('c:/ospanel/domains/localhost/library/config/database.php');

// Подключение обьекта
include_once ('c:/ospanel/domains/localhost/library/objects/publishing_house.php');

$database = new Database();
$db = $database->getConnection();

$publishing_house = new PublishingHouse($db);

// Устанавливаем приоритет вывода по Айди
$publishing_house->id = isset($_GET['id'])? $_GET['id']:die();
// Выводим данные полей автора
$publishing_house->readOne();

if ($publishing_house->title!=null) {

    $publishing_house_arr=array(
        "id"=>$publishing_house->id,
        "title"=>$publishing_house->title
         );

    // Устанавливаем код ответа 200
    http_response_code(200);

    // Выводим в формате json
    echo json_encode($publishing_house_arr);

}
// Устанавливаем код ответа 400
else {
    http_response_code(400);

}
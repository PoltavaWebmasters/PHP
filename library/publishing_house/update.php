<?php

// Прописываем необходимые заголовки

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Подключение базы данных и обьекта
include_once 'c:/ospanel/domains/localhost/library/config/database.php';
include_once 'c:/ospanel/domains/localhost/library/objects/publishing_house.php';

// Подключаем базу данных
$database = new Database();
$db = $database->getConnection();

// Подготавливаем обьект автор
$publishing_house = new PublishingHouse($db);

// Выбираем идентификатор автора для редактирования
$data = json_decode(file_get_contents("php://input"));

$publishing_house->id = $data->id;

// Задаем значения
$publishing_house->title = $data->title;

// Обновляем издательство
if($publishing_house->update()) {
    //Получаем ответ 200 об успешном обновлении записи
    http_response_code(200);
    // Обьявляем пользователю
    echo  json_encode(array("message"=>"Publishing_house update Successfull!"));

}
// Обьявление о неуспешном обновлении записи
else{
    // устанавливаем код ответа 503
    http_response_code(503);
    // Обьявляем пользователю
    echo json_encode(array("message"=>"Unable to update"));

}
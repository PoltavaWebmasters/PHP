<?php

// Заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Подключение базы данных
include_once ('c:/ospanel/domains/localhost/library/config/database.php');

// Подключение обьекта
include_once ('c:/ospanel/domains/localhost/library/objects/publishing_house.php');

$database = new Database();
$db = $database->getConnection();

$publishing_house = new PublishingHouse($db);

// Получаем опубликованные данные
$data = json_decode(file_get_contents("php://input"));

// Проверяем что даные не пустые
if(
    !empty($data->title)
   ){
    // Задаем значения
    $publishing_house->title = $data->title;


    //Создаем новую запись
    if($publishing_house->create()){

        //Получаем ответ 201 об успешном добавлении записи
        http_response_code(201);
        // Обьявляем пользователю
        echo json_encode(array("message"=>"New Publishing_house was created!"));
    }
    // Обьявление о неуспешном создании записи
    else{
        // устанавливаем код ответа 400 ошибка запроса
        http_response_code(400);
        // Обьявляем пользователю
        echo json_encode(array("message"=>"Unable to create, Sorry("));
    }
}


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
include_once ('c:/ospanel/domains/localhost/library/objects/book.php');

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

// Получаем опубликованные данные
$data = json_decode(file_get_contents("php://input"));

// Проверяем что даные не пустые
if(
    !empty($data->title)&&
    !empty($data->author_id)&&
    !empty($data->publishing_house_id)
){
    // Задаем значения
    $book->title = $data->title;
    $book->author_id = $data->author_id;
    $book->publishing_house_id = $data->publishing_house_id;

    //Создаем новую запись
    if($book->create()){

        //Получаем ответ 201 об успешном добавлении записи
        http_response_code(201);
        // Обьявляем пользователю
        echo json_encode(array("message"=>"New Book was created!"));
    }
    // Обьявление о неуспешном создании записи
    else{
        // устанавливаем код ответа 400 ошибка запроса
        http_response_code(400);
        // Обьявляем пользователю
        echo json_encode(array("message"=>"Unable to create, Sorry("));
    }
}



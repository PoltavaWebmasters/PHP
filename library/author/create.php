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
include_once ('c:/ospanel/domains/localhost/library/objects/author.php');

 $database = new Database();
 $db = $database->getConnection();

 $author = new Author($db);

 // Получаем опубликованные данные
 $data = json_decode(file_get_contents("php://input"));

// Проверяем что даные не пустые
 if(
    !empty($data->first_name)&&
    !empty($data->second_name)&&
    !empty($data->book_id)
 ){
    // Задаем значения
    $author->first_name = $data->first_name;
    $author->second_name = $data->second_name;
    $author->book_id = $data->book_id;

    //Создаем новую запись
    if($author->create()){

        //Получаем ответ 201 об успешном добавлении записи
        http_response_code(201);
        // Обьявляем пользователю
        echo json_encode(array("message"=>"New Author was created!"));
    }
    // Обьявление о неуспешном создании записи
    else{
        // устанавливаем код ответа 400 ошибка запроса
        http_response_code(400);
        // Обьявляем пользователю
        echo json_encode(array("message"=>"Unable to create, Sorry("));
    }
}


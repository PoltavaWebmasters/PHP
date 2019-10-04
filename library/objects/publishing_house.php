<?php

class PublishingHouse{

    //Параметры базы данных и имя таблицы
    private $conn;
    private $table_name = "publishing_house";

    // Свойства обьекта
    public $id;
    public $title;


    // Используем  конструктор __construct($db) для передачи параметров в базу данных

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Чтение данных таблицы авторов

    function read()
    {
        // запрос SELECT ALL для всех данных таблицы
        $query = "SELECT * 
                  from ".$this->table_name."
                  ";

        // подготавливаем запрос
        $stmt = $this->conn->prepare($query);

        //выполняем запрос
        $stmt->execute();

        return $stmt;

    }
    // Создание новой записи
    function create()
    {
        //Запрос для добавления записи
        $query="INSERT INTO
                   " . $this->table_name . "
                 SET
                  title=:title";

        // Подготавливаем запрос
        $stmt=$this->conn->prepare($query);

        $this->title=htmlspecialchars(strip_tags($this->title));


        //Связываем значения
        $stmt->bindParam(":title", $this->title);


        //Выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    // Просмотр данных по одной записи
    function readOne()
    {
        $query = "SELECT *
                  From
                    " . $this->table_name . " 
                  WHERE
                   id = ?
                 ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];

    }


    // Обноляем запись в таблицу издательств
    function update()
    {
        // Запрос на обновление
        $query = "UPDATE 
                   ". $this->table_name . "
                   SET
                    title = :title
                   WHERE
                    id = :id";

        // Подготавливаем запрос
        $stmt = $this->conn->prepare($query);

        $this->title=htmlspecialchars(strip_tags($this->title));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':id', $this->id);

        // Выполняем запрос
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Удаление записи из таблицы издательств
    function delete()
    {
        // Запрос на удаление
        $query = "Delete 
                  From
                    " . $this->table_name . " 
                  WHERE
                   id = ?
                 ";

        // Подготавливаем запрос
        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        // Выполняем запрос
        if($stmt->execute()){
            return true;
        }
        return false;

    }
}

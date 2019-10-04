<?php

class Book{

    //Параметры базы данных и имя таблицы
    private $conn;
    private $table_name = "book";

    // Свойства обьекта
    public $id;
    public $title;
    public $author_id;
    public $publishing_house_id;

    // Используем  конструктор __construct($db) для передачи параметров в базу данных

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Чтение данных таблицы книг

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

    // Создаем новую запись в таблицу книг

    function create()
    {
        //Запрос для добавления записи
        $query="INSERT INTO
                   " . $this->table_name . "
                 SET
                  title=:title, author_id=:author_id, publishing_house_id=:publishing_house_id";

        // Подготавливаем запрос
        $stmt=$this->conn->prepare($query);

        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->author_id=htmlspecialchars(strip_tags($this->author_id));
        $this->publishing_house_id=htmlspecialchars(strip_tags($this->publishing_house_id));

        //Связываем значения
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":publishing_house_id", $this->publishing_house_id);

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
        $this->author_id = $row['author_id'];
        $this->publishing_house_id = $row['publishing_house_id'];

    }

    // Обноляем запись в таблицу книг
    function update()
    {
        // Запрос на обновление
        $query = "UPDATE 
                   ". $this->table_name . "
                   SET
                    title = :title,
                    author_id = :author_id,
                    publishing_house_id = :publishing_house_id
                   WHERE
                    id = :id";

        // Подготавливаем запрос
        $stmt = $this->conn->prepare($query);

        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->author_id=htmlspecialchars(strip_tags($this->author_id));
        $this->publishing_house_id=htmlspecialchars(strip_tags($this->publishing_house_id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':publishing_house_id', $this->publishing_house_id);
        $stmt->bindParam(':id', $this->id);

        // Выполняем запрос
        if($stmt->execute()){
            return true;
        }
        return false;
    }


    // Удаление записи из таблицы книг
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

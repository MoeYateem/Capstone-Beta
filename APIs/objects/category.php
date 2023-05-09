<?php

class category
{
    public $conn;
    public $table = "category";
    public $category_ID;
    public $category_Name;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function createCategory()
    {
        $sqlQuery = "INSERT INTO " . $this->table . " (category_Name) VALUES (:category_Name)";
        $exec = $this->conn->prepare($sqlQuery);


        $exec->bindParam(":category_Name", $this->category_Name);

        if ($exec->execute()) {
            return true;
        }
        return false;
    }

    public function getCategory()
    {
        $sqlQuery = "SELECT * FROM " . $this->table;
        $exec = $this->conn->prepare($sqlQuery);
        $exec->execute();
        return $exec;
    }

    public function selectCategory()
    {
        $sqlQuery = "SELECT * FROM " . $this->table . " WHERE category_ID = ? LIMIT 0,1";
        $exec = $this->conn->prepare($sqlQuery);
        $exec->bindParam(1, $this->category_ID);
        $exec->execute();
        $dataRow = $exec->fetch(PDO::FETCH_ASSOC);

        $this->category_ID = $dataRow['category_ID'];
        $this->category_Name = $dataRow['category_Name'];
    }



    public function updateCategory()
    {
        $sqlQuery = "UPDATE category SET category_Name = :category_Name WHERE category_ID = :category_ID";

        $exec = $this->conn->prepare($sqlQuery);


        $exec->bindParam(':category_ID', $this->category_ID);
        $exec->bindParam(':category_Name', $this->category_Name);

        if ($exec->execute()) {
            return true;
        }
        return false;
    }

    function deleteCategory()
    {
        $sqlQuery = "DELETE FROM " . $this->table . " WHERE category_ID =?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->category_ID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
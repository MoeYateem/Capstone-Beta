<?php

class product
{
    public $conn;
    public $table = "product";
    public $product_ID;
    public $product_Name;
    public $product_Quantity;
    public $product_Price;
    public $category_ID;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function createProduct()
    {
        $sqlQuery = "INSERT INTO " . $this->table . " (product_Name, product_Quantity,product_Price,category_ID) VALUES (:product_Name, :product_Quantity,:product_Price,:category_ID)";
        $exec = $this->conn->prepare($sqlQuery);


        $exec->bindParam(":product_Name", $this->product_Name);
        $exec->bindParam(":product_Quantity", $this->product_Quantity);
        $exec->bindParam(":product_Price", $this->product_Price);
        $exec->bindParam(":category_ID", $this->category_ID);


        if ($exec->execute()) {
            return true;
        }
        return false;
    }

    public function getProducts() //read all products
    {
        $sqlQuery = "SELECT * FROM " . $this->table;
        $exec = $this->conn->prepare($sqlQuery);
        $exec->execute();
        return $exec;
    }


    public function selectProduct()
    {
        $sqlQuery = "SELECT * FROM " . $this->table . " WHERE product_ID = ? LIMIT 0,1";
        $exec = $this->conn->prepare($sqlQuery);
        $exec->bindParam(1, $this->product_ID);
        $exec->execute();
        $dataRow = $exec->fetch(PDO::FETCH_ASSOC);

        $this->product_ID= $dataRow['product_ID'];
        $this -> product_Name = $dataRow['product_Name'];
        $this->product_Quantity = $dataRow['product_Quantity'];
        $this->product_Price = $dataRow['product_Price'];
        $this->category_ID = $dataRow['category_ID'];

    }



    public function updateProduct()
    {
        $sqlQuery = "UPDATE product SET product_Name = :product_Name,product_Quantity = :product_Quantity,product_Price = :product_Price, category_ID = :category_ID WHERE product_ID = :product_ID ";

        $exec = $this->conn->prepare($sqlQuery);

        $exec->bindParam(':product_ID', $this->product_ID);
        $exec->bindParam(':product_Name', $this->product_Name);
        $exec->bindParam(':product_Quantity', $this->product_Quantity);
        $exec->bindParam(':product_Price', $this->product_Price);
        $exec->bindParam(':category_ID', $this->category_ID);

        if ($exec->execute()) {
            return true;
        }
        return false;
    }

    function deleteProduct()
    {
        $sqlQuery = "DELETE FROM " . $this->table . " WHERE product_ID =?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->product_ID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
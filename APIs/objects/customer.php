<?php

class customer
{
    public $conn;
    public $table = "user";
    public $fname;
    public $lname;
    public $email;
    public $password;
    

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createCustomer()
    {
        $sqlQuery = "INSERT INTO " . $this->table . " (fname,lname,email,password) VALUES (:fname,:lname,:email,:password)";


        $exec = $this->conn->prepare($sqlQuery);

        //bind it
       // $exec->bindParam("customer_ID",$this->customer_ID);
        $exec->bindParam("fname",$this->fname);
        $exec->bindParam("lname",$this->lname);
        $exec->bindParam("email",$this->email);
        $exec->bindParam("password",$this->password);

        if ($exec->execute()) {
            return true;
        }
        return false;
    }

    // //read function
    // public function getCustomers()
    // {
    //     $sqlQuery = "SELECT * FROM " . $this->table;
    //     $exec = $this->conn->prepare($sqlQuery);
    //     $exec->execute();
    //     return $exec;
    // }
    // //read one rows
    
    // public function selectCustomer()
    // {
    //     $sqlQuery = "SELECT * FROM " . $this->table . " WHERE customer_ID = ? LIMIT 0,1";
    //     $exec = $this->conn->prepare($sqlQuery);
    //     $exec->bindParam(1, $this->customer_ID);
    //     $exec->execute();
    //     $dataRow = $exec->fetch(PDO::FETCH_ASSOC); // read into this

    //     $this->customer_ID = $dataRow['customer_ID'];
    //     $this->customer_FirstName = $dataRow['customer_FirstName'];
    //     $this->customer_LastName = $dataRow['customer_LastName'];
    //     $this->customer_Email = $dataRow['customer_Email'];
    //     $this->customer_Password = $dataRow['customer_Password'];
    //     $this->customer_TotalPoints = $dataRow['customer_TotalPoints'];
    //     $this->customer_RemainingPoints = $dataRow['customer_RemainingPoints'];
    //     $this->customer_PhoneNumber = $dataRow['customer_PhoneNumber'];
    //     $this->tier_ID = $dataRow['tier_ID'];
    // }

    // public function updateCustomer()
    // {
    //     $sqlQuery = "UPDATE customer SET customer_FirstName = :customer_FirstName, customer_LastName = :customer_LastName, customer_Email = :customer_Email, customer_Password = :customer_Password,customer_TotalPoints = :customer_TotalPoints, customer_RemainingPoints = :customer_RemainingPoints, customer_PhoneNumber = :customer_PhoneNumber, tier_ID = :tier_ID WHERE customer_ID = :customer_ID";
    //      //$sqlQuery = "UPDATE customer SET customer_FirstName = :customer_FirstName WHERE customer_ID = :customer_ID";
    //     $exec = $this->conn->prepare($sqlQuery);

    //     $exec->bindParam(':customer_ID',$this->customer_ID);
    //     $exec->bindParam(':customer_FirstName', $this->customer_FirstName);
    //     $exec->bindParam(':customer_LastName', $this->customer_LastName);
    //     $exec->bindParam(':customer_Email', $this->customer_Email);
    //     $exec->bindParam(':customer_Password',$this->customer_Password);
    //     $exec->bindParam(':customer_TotalPoints',$this->customer_TotalPoints);
    //     $exec->bindParam(':customer_RemainingPoints',$this->customer_RemainingPoints);
    //     $exec->bindParam(':tier_ID',$this->tier_ID);
    //     $exec->bindParam(':customer_PhoneNumber',$this->customer_PhoneNumber);

    //     if ($exec->execute()) {
    //         return true;
    //     }
    //     return false;
    // }
    // function deleteCustomer()
    // {
    //     $sqlQuery = "DELETE FROM " . $this->table . " WHERE customer_ID =?";
    //     $stmt = $this->conn->prepare($sqlQuery);
    //     $stmt->bindParam(1, $this->customer_ID);

    //     if ($stmt->execute()) {
    //         return true;
    //     }
    //     return false;
    // }

}
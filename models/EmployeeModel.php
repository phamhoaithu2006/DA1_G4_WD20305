<?php


class EmployeeModel {
   public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllEmployees() {
        $sql = "SELECT * FROM Employee ORDER BY FullName";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmployeeByID($id) {
        $sql = "SELECT * FROM Employee WHERE EmployeeID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addEmployee($name, $role, $phone, $email) {
        $sql = "INSERT INTO Employee (FullName, Role, Phone, Email) VALUES (:name, :role, :phone, :email)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name'=>$name,
            ':role'=>$role,
            ':phone'=>$phone,
            ':email'=>$email
        ]);
    }

    public function updateEmployee($id, $name, $role, $phone, $email) {
        $sql = "UPDATE Employee SET FullName=:name, Role=:role, Phone=:phone, Email=:email WHERE EmployeeID=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id'=>$id,
            ':name'=>$name,
            ':role'=>$role,
            ':phone'=>$phone,
            ':email'=>$email
        ]);
    }

    public function deleteEmployee($id) {
        $sql = "DELETE FROM Employee WHERE EmployeeID=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id'=>$id]);
    }
}
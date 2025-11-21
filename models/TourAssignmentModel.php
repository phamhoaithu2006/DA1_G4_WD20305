<?php

class TourAssignmentModel {
    private $conn;

    public function __construct() {
       
        $this->conn = connectDB();
    }

    public function getAssignmentsByTour($tourID) {
        $sql = "SELECT ta.*, e.FullName, e.Role 
                FROM TourAssignment ta
                INNER JOIN Employee e ON ta.EmployeeID = e.EmployeeID
                WHERE ta.TourID=:tourID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tourID'=>$tourID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAssignment($tourID, $employeeID, $role) {
        $sql = "INSERT INTO TourAssignment (TourID, EmployeeID, Role) VALUES (:tourID, :employeeID, :role)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':tourID'=>$tourID, ':employeeID'=>$employeeID, ':role'=>$role]);
    }

    public function deleteAssignment($id) {
        $sql = "DELETE FROM TourAssignment WHERE AssignmentID=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id'=>$id]);
    }
}
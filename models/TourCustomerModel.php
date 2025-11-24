<?php

class TourCustomerModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getCustomersByTour($tourID) {
        $sql = "SELECT tc.*, c.FullName, c.Phone, c.Email 
                FROM TourCustomer tc
                INNER JOIN Customer c ON tc.CustomerID = c.CustomerID
                WHERE tc.TourID=:tourID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tourID'=>$tourID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTourCustomer($tourID, $customerID, $roomNumber, $note) {
        $sql = "INSERT INTO TourCustomer (TourID, CustomerID, RoomNumber, Note) 
                VALUES (:tourID, :customerID, :roomNumber, :note)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tourID'=>$tourID,
            ':customerID'=>$customerID,
            ':roomNumber'=>$roomNumber,
            ':note'=>$note
        ]);
    }
}
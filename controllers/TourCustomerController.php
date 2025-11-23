<?php
require_once 'models/TourCustomerModel.php';

class TourCustomerController {
    private $model;

    public function __construct() {
        $this->model = new TourCustomerModel();
    }

    public function index($tourID) {
        $customers = $this->model->getCustomersByTour($tourID);
        require 'views/admin/Operate/tourcustomers/list.php';
    }

    public function create($tourID) {
        if($_SERVER['REQUEST_METHOD']==='POST') {
            $this->model->addTourCustomer($tourID, $_POST['customerID'], $_POST['roomNumber'], $_POST['note']);
            header("Location: index.php?action=tourcustomers&tourID=$tourID");
        } else {
            require 'views/admin/Operate/tourcustomers/create.php';
        }
    }
}
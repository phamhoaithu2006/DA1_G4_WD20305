<?php
require_once 'models/TourAssignmentModel.php';
require_once 'models/EmployeeModel.php';

class TourAssignmentController
{
    private $model;
    private $employeeModel;

    public function __construct()
    {
        $this->model = new TourAssignmentModel();
    }
//Hiển thị lịch trình tổng quát
public function index(){
    $tour = new ProductModel();
        $tours = $tour->getAllTour();
    require 'views\admin\Operate\assignments\list.php';
}

//Thông tin chi tiết tour
   public function detail($id)
    {
        $tr = new ProductModel();
        $tour = $tr->getOneDetail($id);
        $title = "This is detail page";
        // var_dump($tour);
        require_once 'views\admin\Operate\assignments\detail.php';
    }
//Thông tin đoàn theo HDV
public function getAllHDV() {
    $data = $this->model->getAllHDV(); // gọi model đã khởi tạo trong __construct()
    var_dump($data);
    require 'views\admin\Operate\assignments\HDV.php';
}


//Thông tin Tổng quát khách hàng 
public function showCustomersByTour($tourId)
{
    // Lấy thông tin tour
    $tour = $this->model->getOneDetail($tourId);

  $customers = $this->model->getCustomersByTour($tourId); 

var_dump($customers);
    // Gọi view hiển thị
    require 'views/admin/Operate/tourcustomers/list.php';
}

//Thông tin chi tiết khách 

//Ghi chú theo khách lấy theo RoomID 
}
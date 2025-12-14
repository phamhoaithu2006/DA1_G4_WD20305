<?php
require_once 'models/TourAssignmentModel.php';
require_once 'models/ProductModel.php'; 

class TourAssignmentController {
    private $model;
    private $productModel;

    public function __construct() {
        $this->model = new TourAssignmentModel();
        $this->productModel = new ProductModel(); // Initialize ProductModel
    }

    // 1. [FIXED] Display General Schedule List (Fixes Fatal Error)
    public function index()
    {
        // Get upcoming tours using the method from ProductModel
        $tours = $this->productModel->getUpcomingTours() ?? []; 
        
        // This view displays the schedule list
        require 'views/admin/Operate/assignments/schedule_list.php'; 
    }

    // 2. Dashboard Operate (Main Dashboard for a single tour)
    public function operate($tourId) {
        // Get Tour Info
        $tour = $this->model->getOneDetail($tourId);
        
        // Get Services
        $services = $this->model->getServicesByTour($tourId);
        
        // Get Assigned Staff
        $assignedStaff = $this->model->getAssignedStaff($tourId);
        
        // Get Customers (for selecting in special requests)
        $customers = $this->model->getTourCustomers($tourId); 
        
        // Get Suppliers (for dropdown)
        $suppliers = $this->model->getAllSuppliers();

        // [NEW] Get Special Requests
        $specialRequests = $this->model->getSpecialRequests($tourId);
        $criticalCount = $this->model->countCriticalPending($tourId); // Alert count

        // [NEW] Get Available Staff for Assignment Modal
        // We get staff who are not busy during this tour's dates
        $availableGuides = $this->model->getAvailableStaff('Hướng dẫn viên', $tour['StartDate'], $tour['EndDate']);
        $availableDrivers = $this->model->getAvailableStaff('Tài xế', $tour['StartDate'], $tour['EndDate']);
        $availableOps = $this->model->getAvailableStaff('Nhân viên điều hành', $tour['StartDate'], $tour['EndDate']);

        require 'views/admin/Operate/assignments/operate_dashboard.php';
    }

    // 3. Logistics Update
    public function updateLogistics() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->updateLogistics($_POST['tour_id'], $_POST['meeting_point'], $_POST['meeting_time']);
            echo "<script>alert('Cập nhật kế hoạch thành công!'); window.history.back();</script>";
        }
    }

    // 4. Staff Assignment
    public function assignStaff() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tourId = $_POST['tour_id'];
            $empId = $_POST['employee_id'];
            $role = $_POST['role'];

            if ($this->model->assignStaff($tourId, $empId, $role)) {
                // [MOCKUP] Send Notification
                $this->sendNotificationToStaff($empId, $tourId, $role);
                echo "<script>alert('Phân công & Gửi thông báo thành công!'); window.history.back();</script>";
            } else {
                echo "<script>alert('Nhân viên này đã được phân công rồi!'); window.history.back();</script>";
            }
        }
    }

    // 5. Remove Staff
    public function removeStaff() {
        if (isset($_GET['id'])) {
            $this->model->removeStaff($_GET['id']);
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }

    // 6. Add Service
    public function addService() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tourId' => $_POST['tour_id'],
                'supId'  => !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null,
                'type'   => $_POST['service_type'],
                'note'   => $_POST['note'],
                'qty'    => $_POST['quantity'],
                'price'  => $_POST['price'],
                'date'   => $_POST['service_date']
            ];
            $this->model->addService($data);
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }

    // 7. Update Service Status
    public function updateServiceStatus() {
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $this->model->updateServiceStatus($_GET['id'], $_GET['status']);
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }

    // 8. [NEW] Add Special Request
    public function addSpecialRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tour_id'     => $_POST['tour_id'],
                'customer_id' => $_POST['customer_id'],
                'type'        => $_POST['request_type'],
                'content'     => $_POST['content'],
                'is_critical' => isset($_POST['is_critical']) ? 1 : 0
            ];

            $this->model->addSpecialRequest($data);
            
            // If critical, trigger alert logic (mockup)
            if ($data['is_critical'] == 1) {
                // $this->notifyGuide(...);
            }

            header("Location: ?act=operate-tour&id=" . $_POST['tour_id']);
            exit;
        }
    }

    // 9. [NEW] Update Request Status
    public function updateRequestStatus() {
        if (isset($_GET['req_id']) && isset($_GET['status'])) {
            $this->model->updateRequestStatus($_GET['req_id'], $_GET['status']);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    // Mockup Notification
    private function sendNotificationToStaff($empId, $tourId, $role) {
        // Logic for email/SMS
    }
    
    // Additional methods for Customers (if needed by your router)
    public function addTourCustomer() {
         // Logic for adding customer to tour
    }
}
?>
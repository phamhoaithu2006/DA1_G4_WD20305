<?php
require_once 'models/ProductModel.php'; // Tận dụng ProductModel để xử lý DB

class SupplierController {
    private $model;

    public function __construct() {
        $this->model = new ProductModel();
    }

    // 1. Danh sách nhà cung cấp
    public function index() {
        $suppliers = $this->model->getAllSuppliers();
        require 'views/admin/Supplier/list.php';
    }

    // 2. Hiển thị form thêm mới
    public function create() {
        require 'views/admin/Supplier/create.php';
    }

    // 3. Xử lý lưu nhà cung cấp mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'SupplierName' => $_POST['name'],
                'ContactInfo'  => $_POST['contact'], // SĐT hoặc Email
                'Address'      => $_POST['address'],
                'ServiceTypes' => $_POST['type'] // VD: Khách sạn, Xe, Nhà hàng
            ];

            if ($this->model->insertSupplier($data)) {
                echo "<script>alert('Thêm thành công!'); window.location.href='?act=suppliers';</script>";
            } else {
                echo "<script>alert('Lỗi thêm mới!'); window.history.back();</script>";
            }
        }
    }

    // 4. Hiển thị form chỉnh sửa
    public function edit($id) {
        $supplier = $this->model->getSupplierById($id);
        if (!$supplier) {
            header("Location: ?act=suppliers");
            exit;
        }
        require 'views/admin/Supplier/edit.php';
    }

    // 5. Xử lý cập nhật
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'SupplierName' => $_POST['name'],
                'ContactInfo'  => $_POST['contact'],
                'Address'      => $_POST['address'],
                'ServiceTypes' => $_POST['type']
            ];

            if ($this->model->updateSupplier($id, $data)) {
                echo "<script>alert('Cập nhật thành công!'); window.location.href='?act=suppliers';</script>";
            } else {
                echo "<script>alert('Lỗi cập nhật!'); window.history.back();</script>";
            }
        }
    }

    // 6. Xóa nhà cung cấp
    public function delete($id) {
        if ($this->model->deleteSupplier($id)) {
            echo "<script>alert('Xóa thành công!'); window.location.href='?act=suppliers';</script>";
        } else {
            echo "<script>alert('Không thể xóa (NCC đang được sử dụng trong Tour/Booking)!'); window.location.href='?act=suppliers';</script>";
        }
    }
}
?>
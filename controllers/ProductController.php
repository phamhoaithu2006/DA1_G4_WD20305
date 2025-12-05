<?php
// Có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
    }

    public function Home()
    {
        $title = "Trang chủ khách hàng";
        require_once './views/trangchu.php';
    }

    public function adminHome()
    {
        $title = "Trang chủ quản lý";
        require_once 'views/admin/home.php';
    }
    public function adminDashboard()
    {
        $tour = new ProductModel();
        $tours = $tour->getAllTour();
        $title = "This is admin home page";
        require_once 'views/admin/Tour_and_product/category.php';
    }
    public function adminDetail($id)
    {
        $tr = new ProductModel();
        $tour = $tr->getOneDetail($id);
        $title = "This is detail page";
        // var_dump($tour);
        require_once 'views/admin/Tour_and_product/detail.php';
    }
    public function Dashboard()
    {
        $db = new DashboardModel();
        $data = [
            'totalCategories' => $db->getTotalCategories(),
            'totalTours'      => $db->getTotalTours(),
            'totalCustomers'  => $db->getTotalCustomers(),
            'totalBookings'   => $db->getTotalBookings(),
            'totalEmployees'  => $db->getTotalEmployees(),
            'recentBookings'  => $db->getRecentBookings(5)
        ];
        require_once 'views/admin/dashboard/dashboard.php';
    }
    public function create() {
        // Xử lý khi người dùng bấm nút "Lưu" (POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $imagePath = null;

            // Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = "uploads/tours/";
                // Tạo thư mục nếu chưa có
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                
                // Di chuyển file
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    $imagePath = $targetFilePath; // Lưu đường dẫn tương đối (uploads/tours/...)
                }
            }

            // Gom dữ liệu
            $data = [
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id'],
                'supplier_id' => $_POST['supplier_id'],
                'price' => $_POST['price'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'description' => $_POST['description'],
                'image' => $imagePath // Lưu đường dẫn ảnh vào DB
            ];

            // Gọi Model để lưu
            if ($this->modelProduct->insertTour($data)) {
                header("Location: ?act=category"); // Thành công thì về danh sách
                exit;
            } else {
                $error = "Có lỗi xảy ra, vui lòng thử lại!";
            }
        }

        // Xử lý hiển thị Form (GET)
        // Lấy danh mục và nhà cung cấp để đổ vào select box
        $categories = $this->modelProduct->getAllCategories();
        $suppliers = $this->modelProduct->getAllSuppliers();

        require_once 'views/admin/Tour_and_product/create.php';
    }
    public function delete($id) {
        // 1. Lấy thông tin tour trước để lấy đường dẫn ảnh
        $tour = $this->modelProduct->getOneDetail($id);

        if (!$tour) {
            echo "<script>alert('Tour không tồn tại!'); window.location.href='?act=category';</script>";
            return;
        }

        // 2. Thực hiện xóa trong Database
        if ($this->modelProduct->deleteTour($id)) {
            // 3. Nếu xóa DB thành công -> Xóa file ảnh trong thư mục uploads (nếu có)
            if (!empty($tour['Image']) && file_exists($tour['Image'])) {
                unlink($tour['Image']);
            }

            // 4. Quay về trang danh sách
            echo "<script>alert('Xóa thành công!'); window.location.href='?act=category';</script>";
        } else {
            echo "<script>alert('Xóa thất bại. Có thể tour đang có đơn hàng liên quan!'); window.location.href='?act=category';</script>";
        }
    }
    
}
<?php
// Có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;


    public function __construct()
    {
        $this->modelProduct = new ProductModel();

        // --- BẮT ĐẦU: KIỂM TRA QUYỀN ADMIN ---
        // Nếu act nằm trong danh sách cần bảo vệ thì phải check login
        $act = $_GET['act'] ?? '/';

        // Danh sách các trang chỉ Admin được vào
        $adminRoutes = [
            'category',
            'detail',
            'dashboard',
            'tour-create',
            'tour-delete',
            'employees',
            'service-add',
            'gallery-upload',
            'tour-itinerary-form'
        ];

        // Nếu đang vào trang Admin
        if (in_array($act, $adminRoutes)) {
            // Khởi động session nếu chưa có
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Kiểm tra: Nếu chưa đăng nhập HOẶC không phải là 'admin'
            if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
                // Đá về trang login của HDV (nơi dùng chung login)
                header("Location: ?act=hdv-login");
                exit;
            }
        }
    }

    public function Home()
    {
        $title = "Trang chủ";
        require_once 'views/admin/home.php';
    }

    public function adminDashboard()
    {
        $tour = new ProductModel();
        $tours = $tour->getAllTour();
        $title = "Tổng quan";
        require_once 'views/admin/Tour_and_product/category.php';
    }
    public function adminDetail($id)
    {
        $tr = new ProductModel();

        // ... Các phần cũ giữ nguyên ...
        $tour = $tr->getOneDetail($id);
        $itinerary = $tr->getTourItinerary($id);
        $gallery = $tr->getTourGallery($id);
        $pricing = $tr->getTourPricing($id);
        $services = $tr->getTourServices($id);

        // [MỚI] Lấy danh sách khách hàng
        $customers = $tr->getTourCustomersList($id);

        $title = "Chi tiết Tour trọn gói";
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
    public function create()
    {
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
    public function delete($id)
    {
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
    // 1. Hiển thị Form thêm lịch trình
    public function itineraryForm($tourId)
    {
        $tr = new ProductModel();
        // Lấy thông tin Tour để hiện tên
        $tour = $tr->getOneDetail($tourId);

        // Nếu không tìm thấy tour, quay về danh sách
        if (!$tour) {
            header("Location: ?act=category");
            exit;
        }

        // Gọi View (Tạo file views/admin/Tour_and_product/itinerary_form.php sau bước này)
        require_once 'views/admin/Tour_and_product/itinerary_form.php';
    }

    // 2. Xử lý Lưu lịch trình (POST)
    public function itineraryStore()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'TourID' => $_POST['tour_id'],
                'DayNumber' => $_POST['day_number'],
                'Title' => $_POST['title'],
                'Description' => $_POST['description'],
                'Accommodation' => $_POST['accommodation'],
                'Meals' => isset($_POST['meals']) ? implode(', ', $_POST['meals']) : '' // Nối mảng checkbox thành chuỗi
            ];

            if ($this->modelProduct->insertItinerary($data)) {
                // Thành công thì quay lại trang chi tiết Tour
                header("Location: ?act=detail&id=" . $data['TourID']);
                exit;
            } else {
                echo "<script>alert('Lỗi thêm lịch trình!'); window.history.back();</script>";
            }
        }
    }

    // 3. Xử lý Xóa lịch trình
    public function itineraryDelete($itineraryId)
    {
        // Cần lấy TourID trước khi xóa để redirect về đúng trang
        // Giả sử Model có hàm getItineraryById, nếu chưa có thì redirect về category tạm

        if ($this->modelProduct->deleteItinerary($itineraryId)) {
            echo "<script>alert('Đã xóa lịch trình!'); window.history.back();</script>";
        } else {
            echo "<script>alert('Lỗi xóa!'); window.history.back();</script>";
        }
    }
    // --- [BỔ SUNG] Xử lý Upload ảnh thư viện ---
    public function galleryUpload()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tour_id = $_POST['tour_id'] ?? null;

            if ($tour_id && !empty($_FILES['gallery_images']['name'][0])) {

                $files = $_FILES['gallery_images'];
                $count = count($files['name']);

                // Đường dẫn lưu ảnh (tương đối so với file index.php)
                $targetDir = "uploads/tours/gallery/";

                // Tạo thư mục nếu chưa có
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Duyệt qua từng file được gửi lên
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] === 0) {
                        // Tạo tên file ngẫu nhiên để tránh trùng
                        $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                        $newFileName = time() . '_' . rand(100, 999) . '.' . $extension;
                        $targetFilePath = $targetDir . $newFileName;

                        // Di chuyển file và lưu vào DB
                        if (move_uploaded_file($files['tmp_name'][$i], $targetFilePath)) {
                            // Gọi Model để insert đường dẫn ảnh
                            $this->modelProduct->insertGalleryImage($tour_id, $targetFilePath);
                        }
                    }
                }

                // Upload xong thì quay lại trang chi tiết
                header("Location: ?act=detail&id=" . $tour_id);
                exit;
            } else {
                echo "<script>alert('Vui lòng chọn ảnh!'); window.history.back();</script>";
            }
        }
    }

    // --- [BỔ SUNG] Xóa ảnh thư viện ---
    public function deleteGalleryImage($imageId, $tourId)
    {
        // 1. Lấy thông tin ảnh để xóa file vật lý
        $image = $this->modelProduct->getGalleryImageById($imageId); // Cần viết hàm này trong Model

        if ($image) {
            // Xóa file trong thư mục uploads
            if (file_exists($image['ImageURL'])) {
                unlink($image['ImageURL']);
            }

            // 2. Xóa dữ liệu trong DB
            $this->modelProduct->deleteGalleryImage($imageId); // Cần viết hàm này trong Model
        }

        // Quay lại trang chi tiết
        header("Location: ?act=detail&id=" . $tourId);
        exit;
    }
    // ... Dán vào trong class ProductController ...

    // 1. Hiển thị Form thêm dịch vụ
    public function serviceCreate()
    {
        // Lấy danh sách Tour và NCC để chọn trong dropdown
        $tours = $this->modelProduct->getAllTour();
        $suppliers = $this->modelProduct->getAllSuppliers();

        // Lấy ID tour từ URL (nếu người dùng bấm từ trang chi tiết)
        $preSelectedTourId = $_GET['tour_id'] ?? null;

        require_once 'views/admin/Tour_and_product/service_create.php';
    }

    // 2. Xử lý lưu dịch vụ
    public function serviceStore()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tour_id'      => $_POST['tour_id'],
                'supplier_id'  => $_POST['supplier_id'],
                'service_type' => $_POST['service_type'],
                'quantity'     => $_POST['quantity'] ?? 1,
                'price'        => $_POST['price'] ?? 0,
                'note'         => $_POST['note'] ?? ''
            ];

            if ($this->modelProduct->insertService($data)) {
                // Thành công -> Quay lại trang chi tiết Tour đó
                echo "<script>alert('Thêm dịch vụ thành công!'); window.location.href='?act=detail&id=" . $data['tour_id'] . "';</script>";
            } else {
                echo "<script>alert('Lỗi hệ thống!'); window.history.back();</script>";
            }
        }
    }
}

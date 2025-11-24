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
        $title = "Home";
        require_once './views/trangchu.php';
    }
    public function adminHome()
    {
        $title = "This is admin home page";
        require_once 'views/admin/sidebar.php';
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
}
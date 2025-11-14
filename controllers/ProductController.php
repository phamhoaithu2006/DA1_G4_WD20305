<?php
// có class chứa các function thực thi xử lý logic 
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
        require_once 'views/admin/admin.php';
    }
}
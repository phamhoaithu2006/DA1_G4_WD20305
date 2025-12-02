<?php
class TourFinanceController
{
    private $model;
    public function __construct()
    {
        $this->model = new TourFinanceModel();
    }


    public function index($tourId)
    {
        $rows = $this->model->getByTour($tourId);
        require_once 'views/admin/tourfinance/index.php';
    }


    public function createForm($tourId)
    {
        require_once 'views/admin/tourfinance/create.php';
    }


    public function store()
    {
        // Lấy dữ liệu từ POST
        $tourId = (int) ($_POST['TourID'] ?? 0);
        $revenue = (float) ($_POST['Revenue'] ?? 0);
        $expense = (float) ($_POST['Expense'] ?? 0);


        // Tính Profit (Lợi nhuận)
        $profit = $revenue - $expense;


        // Chuẩn bị dữ liệu cho Model
        $data = [
            'TourID' => $tourId,
            'Revenue' => $revenue,
            'Expense' => $expense,
            'Profit' => $profit,
        ];


        if ($tourId > 0) {
            $this->model->create($data);
            header('Location: index.php?act=finance-list&tourId=' . $tourId);
            exit;
        } else {
            header('Location: index.php?act=finance-list&tourId=0');
            exit;
        }
    }
    public function editForm($id)
    {
        $row = $this->model->find($id);
        require_once 'views/admin/tourfinance/edit.php';
    }


    public function update($id)
    {
        $revenue = (float) ($_POST['Revenue'] ?? 0);
        $expense = (float) ($_POST['Expense'] ?? 0);
        $profit = $revenue - $expense;


        $data = [
            'Revenue' => $revenue,
            'Expense' => $expense,
            'Profit' => $profit
        ];


        $this->model->update($id, $data);


        $tourId = $_POST['TourID'] ?? 0;
        header('Location: index.php?act=finance-list&tourId=' . urlencode($tourId));
        exit;
    }


    public function delete($id, $tourId)
    {
        $this->model->delete($id);
        header('Location: index.php?act=finance-list&tourId=' . urlencode($tourId));
        exit;
    }
}

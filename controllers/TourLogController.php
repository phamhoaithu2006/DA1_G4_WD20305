<?php
class TourLogController
{
    private $model;
    public function __construct()
    {
        $this->model = new TourLogModel();
    }

    public function index($tourId)
    {
        $logs = $this->model->getAllByTour($tourId);
        require_once 'views/admin/tourlog/index.php';
    }

    public function createForm($tourId)
    {
        $employees = (new EmployeeModel())->getAllEmployees();
        require_once 'views/admin/tourlog/create.php';
    }

    public function store()
    {
        $tourIdSafe = (int) ($_POST['TourID'] ?? 0);
        if ($tourIdSafe === 0) {
            header('Location: index.php?act=tourlog-list');
            exit;
        }

        $data = [
            'TourID' => $tourIdSafe,
            'EmployeeID' => $_POST['EmployeeID'] ?? null,
            'LogDate' => $_POST['LogDate'] ?? date('Y-m-d H:i:s'),
            'Note' => $_POST['Note'] ?? ''
        ];

        $this->model->create($data);
        header('Location: index.php?act=tourlog-list&tourID=' . $tourIdSafe);
        exit;
    }

    public function editForm($id)
    {
        $log = $this->model->find($id);
        $employees = (new EmployeeModel())->getAllEmployees();
        require_once 'views/admin/tourlog/edit.php';
    }

    public function update($id)
    {
        $data = [
            'EmployeeID' => $_POST['EmployeeID'] ?? null,
            'LogDate' => $_POST['LogDate'],
            'Note' => $_POST['Note'] ?? ''
        ];
        $this->model->update($id, $data);
        header('Location: index.php?act=tourlog-list&tourID=' . $_POST['TourID']);
        exit;
    }

    public function delete($id, $tourId)
    {
        $this->model->delete($id);
        header('Location: index.php?act=tourlog-list&tourID=' . $tourId);
        exit;
    }
}

<?php
    namespace monthi\controller;

    use monthi\view\MonthiView;

    require_once ("monthi/model/Monthi.php");
    require_once ("monthi/view/MonthiView.php");

class MonthiController {
    public function __construct() {}
    private $data;

    /**
     * Hiện toàn bộ môn thi dưới dạng bảng
     */
    public function table() {
        $monthi = new \monthi\model\Monthi();

        $this->data = json_encode($monthi->getAll());

        $view = new MonthiView($this->data);
        echo $view->tableView();
    }

    public function showAdd() {
        $view = new MonthiView($this->data);
        echo $view->addForm();
    }

    public function showDelete() {
        $view = new MonthiView($this->data);
        echo $view->deleteForm();
    }

    public function add($mamonthi, $tenmonthi, $tinchi) {
        $monthi = new \monthi\model\Monthi();


    }
}
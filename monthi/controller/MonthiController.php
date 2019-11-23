<?php
    namespace monthi\controller;

    use monthi\view\MonthiView;

    require_once ("monthi/model/Monthi.php");
    require_once ("monthi/view/MonthiView.php");

class MonthiController {
    public function __construct() {
        if (isset($_POST["add"]) && isset($_POST["mamonthi"]) && isset($_POST["tenmonthi"]) && isset($_POST["tinchi"])
            && !empty($_POST["mamonthi"]) && !empty($_POST["tenmonthi"]) && !empty($_POST["tinchi"]) && $_POST["add"] == 1) {
            $this->add($_POST["mamonthi"], $_POST["tenmonthi"], $_POST["tinchi"]);
        } elseif (isset($_POST["delete"]) && isset($_POST["mamonthi"]) && !empty($_POST["mamonthi"])) {
            $this->delete($_POST["mamonthi"]);
        }
    }
    private $data;

    /**
     * Hiện toàn bộ môn thi dưới dạng bảng
     */
    public function table() {
        $monthi = new \monthi\model\Monthi();

        $this->data = json_encode($monthi->getAll());
        $view = new MonthiView($this->data);
        $view->tableView();
    }

    public function showAdd() {
        $view = new MonthiView($this->data);
        $view->addForm();
    }

    public function showDelete() {
        $view = new MonthiView($this->data);
        $view->deleteForm();
    }

    public function add($mamonthi, $tenmonthi, $tinchi) {
        $monthi = new \monthi\model\Monthi();
        $monthi->add($mamonthi, $tenmonthi, $tinchi);
    }

    public function delete($mamonthi) {
        $monthi = new \monthi\model\Monthi();
        $monthi->delete($mamonthi);
    }
}
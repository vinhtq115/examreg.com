<?php
    namespace monthi\controller;

    use monthi\view\MonthiView;

    require_once ("monthi/model/Monthi.php");
    require_once ("monthi/view/MonthiView.php");

class MonthiController {
    private $error_msg_add = ""; // Chứa thông báo lỗi của form add
    private $success_msg_add = ""; // Chứa thông báo thành công của form add
    private $error_msg_delete = ""; // Chứa thông báo lỗi của form delete
    private $success_msg_delete = ""; // Chứa thông báo thành công của form delete

    public function __construct() {
        if (isset($_POST["add"]) && isset($_POST["mamonthi"]) && isset($_POST["tenmonthi"]) && isset($_POST["tinchi"])
            && !empty($_POST["mamonthi"]) && !empty($_POST["tenmonthi"]) && !empty($_POST["tinchi"]) && $_POST["add"] == 1) {
            $this->error_msg_add = $this->add($_POST["mamonthi"], $_POST["tenmonthi"], $_POST["tinchi"]);
            $this->error_msg_delete = "";
        } elseif (isset($_POST["delete"]) && isset($_POST["mamonthi"]) && !empty($_POST["mamonthi"])) {
            $this->error_msg_delete = $this->delete($_POST["mamonthi"]);
            $this->error_msg_add = "";
        } else {
            $this->error_msg_delete = "";
            $this->error_msg_add = "";
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
        $view->addForm($this->success_msg_add, $this->error_msg_add);
    }

    public function showDelete() {
        $view = new MonthiView($this->data);
        $view->deleteForm($this->success_msg_delete, $this->error_msg_delete);
    }

    public function add($mamonthi, $tenmonthi, $tinchi) {
        $monthi = new \monthi\model\Monthi();
        return $monthi->add($mamonthi, $tenmonthi, $tinchi);
    }

    public function delete($mamonthi) {
        $monthi = new \monthi\model\Monthi();
        $monthi->delete($mamonthi);
    }
}

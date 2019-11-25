<?php
    namespace monthi\controller;

    use monthi\model\Monthi;
    use monthi\view\MonthiView;

    require_once dirname(__FILE__)."/../model/Monthi.php";
    require_once dirname(__FILE__)."/../view/MonthiView.php";

class MonthiController {
    private $error_msg_add = ""; // Chứa thông báo lỗi của form add
    private $success_msg_add = ""; // Chứa thông báo thành công của form add
    private $error_msg_delete = ""; // Chứa thông báo lỗi của form delete
    private $success_msg_delete = ""; // Chứa thông báo thành công của form delete

    private $data; // Chứa dữ liệu cho view (JSON)

    /**
     * MonthiController constructor.
     */
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

    /**
     * Hiện toàn bộ môn thi dưới dạng bảng.
     */
    public function table() {
        $monthi = new Monthi();

        $this->data = json_encode($monthi->getAll());
        $view = new MonthiView($this->data);
        echo $view->tableView();
    }

    /**
     * Hiện form thêm môn thi.
     */
    public function showAdd() {
        $view = new MonthiView($this->data);
        $view->addForm($this->success_msg_add, $this->error_msg_add);
    }

    /**
     * Hiện form xóa môn thi.
     */
    public function showDelete() {
        $view = new MonthiView($this->data);
        $view->deleteForm($this->success_msg_delete, $this->error_msg_delete);
    }

    /**
     * Hàm thêm môn thi.
     * @param $mamonthi: Mã môn thi.
     * @param $tenmonthi: Tên môn thi.
     * @param $tinchi: Số tín chỉ.
     * @return int
     */
    public function add($mamonthi, $tenmonthi, $tinchi) {
        $monthi = new Monthi();
        return $monthi->add($mamonthi, $tenmonthi, $tinchi);
    }

    public function delete($mamonthi) {
        $monthi = new Monthi();
        $monthi->delete($mamonthi);
    }
}

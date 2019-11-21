<?php


namespace monthi\view;


class MonthiView {
    private $data; // Danh sach mon thi

    /**
     * Khởi tạo monthiView.
     * @param $data: Chứa danh sách môn thi (JSON).
     */
    public function __construct($data) {
        $this->data = json_decode($data, true);
    }

    /**
     * Bảng các môn thi
     * @return string: Code HTML
     */
    public function tableView() {
        $html = "<table class='table table-bordered'><thead><tr>";
        $html .= "<th>Mã môn thi</th>";
        $html .= "<th>Tên môn thi</th>";
        $html .= "<th>Tín chỉ</th>";
        $html .= "</tr></thead><tbody>";
        foreach ($this->data as $key => $value) {
            $html .= "<tr>";
            $html .= "<td>" . $value["mamonthi"] . "</td>";
            $html .= "<td>" . $value["tenmonthi"] . "</td>";
            $html .= "<td>" . $value["tinchi"] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";

        return $html;
    }

    public function addForm() {
        $html = "<form>
                  <div class=\"form-group\">
                    <label for=\"mamonthi\">Mã môn thi</label>
                    <input type=\"text\" class=\"form-control\" id=\"mamonthi\" placeholder=\"Nhập mã môn thi\">
                  </div>
                  <div class=\"form-group\">
                    <label for=\"tenmonthi\">Tên môn thi</label>
                    <input type=\"text\" class=\"form-control\" id=\"tenmonthi\" placeholder=\"Tên môn thi\">
                  </div>
                  <div class=\"form-group\">
                    <label for=\"tinchi\">Tín chỉ</label>
                    <input type=\"number\" class=\"form-control\" id=\"tinchi\" placeholder=\"Tín chỉ\">
                  </div>
                  <button type=\"submit\" class=\"btn btn-primary\">Thêm</button>
                </form>";
        return $html;
    }
}
<?php


namespace monthi\view;


class MonthiView {
    private $data; // Danh sách môn thi

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
        $html = "<table class='table table-bordered table-striped table-hover'><thead><tr>";
        $html .= "<th>Mã môn thi</th>";
        $html .= "<th>Tên môn thi</th>";
        $html .= "<th>Tín chỉ</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $html .= "<tr>";
                $html .= "<td class='mamonthi'>" . $value["mamonthi"] . "</td>";
                $html .= "<td class='tenmonthi'>" . $value["tenmonthi"] . "</td>";
                $html .= "<td class='tinchi'>" . $value["tinchi"] . "</td>";
                $html .= "</tr>";
            }
        } else { // Tạo ô trống nếu size = 0
            $html .= "<td colspan='3' style=\"text-align:center\">Chưa có môn thi.</td>";
        }
        $html .= "</tbody></table>";

        return $html;
    }

    /**
     * Hiện form thêm môn học.
     */
    public function addForm() {
        $html = "<form method=\"post\" id='form_add'>
                  <div class=\"form-group\">
                    <label for=\"mamonthi_add\">Mã môn thi</label>
                    <input type=\"text\" class=\"form-control\" id=\"mamonthi_add\" name=\"mamonthi\" placeholder=\"Nhập mã môn thi muốn thêm\" maxlength='20' minlength='1' required>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"tenmonthi_add\">Tên môn thi</label>
                    <input type=\"text\" class=\"form-control\" id=\"tenmonthi_add\" name=\"tenmonthi\" placeholder=\"Tên môn thi\" maxlength='100' minlength='1' required>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"tinchi_add\">Tín chỉ</label>
                    <input type=\"number\" class=\"form-control\" id=\"tinchi_add\" name=\"tinchi\" placeholder=\"Tín chỉ\" min='1' required>
                  </div>";
        $html .= "<button type=\"button\" id='add-button' class=\"btn btn-primary\">Thêm</button></form>";
        return $html;
    }

    /**
     * Hiện form xóa môn học theo mã môn học.
     */
    public function deleteForm() {
        $html = "<form method=\"post\" id='form_delete' autocomplete='off'>
                  <div class=\"form-group\">
                    <label for=\"mamonthi_delete\">Mã môn thi</label>
                    <input list='danhsachmonhoc' type=\"text\" class=\"form-control\" id=\"mamonthi_delete\" name=\"mamonthi\" placeholder=\"Nhập mã môn thi cần xóa\" required>
                    <datalist id='danhsachmonhoc'>";
        foreach ($this->data as $key => $value) {
            $html .= "<option value=\"".$value["mamonthi"]."\">";
        }
        $html .= "</datalist></div>";
        $html .= "<button type=\"button\" id='delete-button' class=\"btn btn-danger\">Xóa</button></form>";
        return $html;
    }

    /**
     * Hiện form sửa môn học.
     */
    public function editForm() {
        $html = "<form method=\"post\" id='form_edit' autocomplete='off'>
                    <div class=\"form-group\">
                        <label for=\"mamonthi_edit\">Mã môn thi</label>
                        <input list='danhsachmonhoc' type=\"text\" class=\"form-control\" id=\"mamonthi_edit\" name=\"mamonthi\" placeholder=\"Nhập mã môn thi muốn sửa\" maxlength='20' minlength='1' required>
                    </div>
                  <div class=\"form-group\">
                    <label for=\"tenmonthi_edit\">Tên môn thi</label>
                    <input type=\"text\" class=\"form-control\" id=\"tenmonthi_edit\" name=\"tenmonthi\" placeholder=\"Tên môn thi\" maxlength='100' minlength='1' required>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"tinchi_edit\">Tín chỉ</label>
                    <input type=\"number\" class=\"form-control\" id=\"tinchi_edit\" name=\"tinchi\" placeholder=\"Tín chỉ\" min='1' required>
                  </div>";
        $html .= "<button type=\"button\" class=\"btn btn-primary\" id='edit-button'>Sửa</button></form>";
        return $html;
    }
}
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
        $html = "<table id='tablemonthi' class='table table-bordered table-striped table-hover table-sm'><thead><tr>";
        $html .= "<th class='th-sm'>Mã môn thi</th>";
        $html .= "<th class='th-sm'>Tên môn thi</th>";
        $html .= "<th class='th-sm'>Tín chỉ</th>";
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
        $html .= "</tbody><tfoot><tr>";
        $html .= "<th>Mã môn thi</th><th>Tên môn thi</th><th>Tín chỉ</th>";
        $html .= "</tr></tfoot></table>";

        return $html;
    }

    /**
     * Datalist các mã môn thi
     * @param $json
     * @return string
     */
    public function datalist_monthi($json) {
        $ds = json_decode($json, true);
        $size = sizeof($ds);
        // Hiện datalist
        $html = "<datalist id='danhsachmonhoc'>";
        for ($i = 0; $i < $size; $i++) {
            $a = json_encode($ds[$i]);
            $b = json_decode($a);
            $html .= "<option value=\"".$b->mamonthi."\">";
        }
        $html .= "</datalist>";
        return $html;
    }

    /**
     * Hiện form thêm môn học.
     */
    public function addForm() {
        $html = "<form method=\"post\" id='form_add' autocomplete='off'>
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
                    <input list='danhsachmonhoc' type=\"text\" class=\"form-control\" id=\"mamonthi_delete\" name=\"mamonthi\" placeholder=\"Nhập mã môn thi cần xóa\" required>";
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
<?php


namespace kythi\view;


class KythiView {
    private $data; // Danh sách kỳ thi

    /**
     * Khởi tạo KythiView.
     * @param $data: Chứa danh sách kỳ thi (JSON).
     */
    public function __construct($data) {
        $this->data = json_decode($data, true);
    }

    /**
     * Bảng các kỳ thi
     * @return string: Code HTML
     */
    public function tableView() {
        $html = "<table id='tablekythi' class='table table-bordered table-striped table-hover table-sm'><thead><tr>";
        $html .= "<th class='th-sm'>Mã kỳ thi</th>";
        $html .= "<th class='th-sm'>Năm bắt đầu</th>";
        $html .= "<th class='th-sm'>Năm kết thúc</th>";
        $html .= "<th class='th-sm'>Kỳ</th>";
        $html .= "<th class='th-sm'>Ngày bắt đầu thi</th>";
        $html .= "<th class='th-sm'>Ngày kết thúc thi</th>";
        $html .= "<th class='th-sm qlct'>Ca thi</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $html .= "<tr>";
                $html .= "<td class='align-middle'>" . $value["id"] .($value["active"]==1?" (Hiện tại)":"") . "</td>";
                $html .= "<td class='align-middle'>" . $value["nambatdau"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["namketthuc"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["ky"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["ngaybatdau"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["ngayketthuc"] . "</td>";
                $html .= "<td class='qlct align-middle'><a class='btn btn-indigo btn-sm m-0' href='http://examreg.com/kythi/".$value["id"]."'>Ca thi</a></td>";
                $html .= "</tr>";
            }
        }
        $html .= "</tbody><tfoot><tr>";
        $html .= "<th>Mã kỳ thi</th><th>Năm bắt đầu</th><th>Năm kết thúc</th><th>Kỳ</th><th>Ca thi</th><th>Ngày bắt đầu thi</th><th>Ngày kết thúc thi</th>";
        $html .= "</tr></tfoot></table>";

        return $html;
    }

    /**
     * Datalist các mã kỳ thi
     * @return string
     */
    public function datalist_kythi() {
        $size = sizeof($this->data);
        // Hiện datalist
        $html = "<datalist id='danhsachkythi'>";
        for ($i = 0; $i < $size; $i++) {
            $a = json_encode($this->data[$i]);
            $b = json_decode($a);
            $html .= "<option value=\"".$b->id."\">"."Kỳ ".$b->ky." năm ".$b->nambatdau."-".$b->namketthuc." (".$b->ngaybatdau." - ".$b->ngayketthuc.")";
        }
        $html .= "</datalist>";
        return $html;
    }

    /**
     * Hiện form thêm kỳ thi.
     * @return string
     */
    public function addForm() {
        $html = "<form method='post' id='form_add'>
                  <div class='form-group'>
                    <label for='nambatdau_add'>Năm bắt đầu</label>
                    <input type='number' class='form-control' id='nambatdau_add' name='nambatdau' placeholder='Nhập năm bắt đầu' min='1900' max='2099' required>
                  </div>
                  <div class='form-group'>
                    <label for='namketthuc_add'>Năm kết thúc</label>
                    <input type='number' class='form-control' id='namketthuc_add' name='namketthuc' placeholder='Nhập năm kết thúc' min='1900' max='2099' required>
                  </div>
                  <div class='form-group'>
                    <label for='ky_add'>Kỳ</label>
                    <input type='number' class='form-control' id='ky_add' name='ky' placeholder='Nhập kỳ' min='1' required>
                  </div>
                  <div class='form-group'>
                    <label for='ngaybatdau_add'>Ngày bắt đầu thi</label>
                    <input type='date' class='form-control' id='ngaybatdau_add' name='ngaybatdau' placeholder='Nhập ngày bắt đầu thi' required>
                  </div>
                  <div class='form-group'>
                    <label for='ngayketthuc_add'>Ngày kết thúc thi</label>
                    <input type='date' class='form-control' id='ngayketthuc_add' name='ngayketthuc' placeholder='Nhập ngày kết thúc thi' required>
                  </div>";
        $html .= "<button type='button' id='add-button' class='btn btn-primary'>Thêm</button></form>";
        return $html;
    }

    /**
     * Hiện form xóa kỳ thi theo mã kỳ thi.
     * @return string
     */
    public function deleteForm() {
        $html = "<form method='post' id='form_delete' autocomplete='off'>
                  <div class='form-group'>
                    <label for='makythi'>Mã kỳ thi</label>
                    <input list='danhsachkythi' type='text' class='form-control' id='makythi_delete' name='makythi' placeholder='Nhập mã kỳ thi cần xóa' minlength='1' maxlength='11' required>
                </div>";
        $html .= "<button type='button' id='delete-button' class='btn btn-danger'>Xóa</button></form>";
        return $html;
    }

    /**
     * Hiện form sửa kỳ thi.
     */
    public function editForm() {
        $html = "<form method='post' id='form_edit' autocomplete='off'>
                    <div class='form-group'>
                        <label for='makythi'>Mã kỳ thi</label>
                        <input list='danhsachkythi' type='text' class='form-control' id='makythi_edit' name='makythi' placeholder='Nhập mã kỳ thi muốn sửa' minlength='1' maxlength='11' required>
                    </div>
                  <div class='form-group'>
                    <label for='nambatdau_edit'>Năm bắt đầu</label>
                    <input type='number' class='form-control' id='nambatdau_edit' name='nambatdau' placeholder='Năm bắt đầu' min='1900' max='2099' required>
                  </div>
                  <div class='form-group'>
                    <label for='namketthuc_edit'>Năm kết thúc</label>
                    <input type='number' class='form-control' id='namketthuc_edit' name='namketthuc' placeholder='Năm kết thúc' min='1900' max='2099' required>
                  </div>
                  <div class='form-group'>
                    <label for='ky_edit'>Kỳ</label>
                    <input type='number' class='form-control' id='ky_edit' name='ky' placeholder='Kỳ' min='1' required>
                  </div>
                  <div class='form-group'>
                    <label for='ngaybatdau_edit'>Ngày bắt đầu thi</label>
                    <input type='date' class='form-control' id='ngaybatdau_edit' name='ngaybatdau' placeholder='Ngày bắt đầu thi' required>
                  </div>
                  <div class='form-group'>
                    <label for='ngayketthuc_edit'>Ngày kết thúc thi</label>
                    <input type='date' class='form-control' id='ngayketthuc_edit' name='ngayketthuc' placeholder='Ngày kết thúc thi' required>
                  </div>";
        $html .= "<button type='button' class='btn btn-primary' id='edit-button'>Sửa</button></form>";
        return $html;
    }

    /**
     * Form chọn kỳ thi hiện tại.
     */
    public function chooseActiveSemester() {
        $html = "<form method='post' id='form_active' autocomplete='off'>
                    <div class='form-group'>
                        <label for='makythi'>Mã kỳ thi</label>
                        <input list='danhsachkythi' type='text' class='form-control' id='makythi_active' name='makythi' placeholder='Nhập mã kỳ thi' minlength='1' maxlength='11' required>
                    </div>
                    <button type='button' class='btn btn-primary' id='active-button'>Đặt làm kỳ thi hiện tại.</button>
                </form>";
        return $html;
    }
}
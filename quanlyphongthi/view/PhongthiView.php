<?php


namespace quanlyphongthi\view;


class PhongthiView {
    private $data; // Danh sách phòng thi

    /**
     * Khởi tạo PhongthiView.
     * @param $data: Chứa danh sách phòng thi (JSON).
     */
    public function __construct($data) {
        $this->data = json_decode($data, true);
    }

    /**
     * Bảng các phòng thi
     * @return string: Code HTML
     */
    public function tableView() {
        $html = "<table id='tablephongthi' class='table table-bordered table-striped table-hover table-sm'><thead><tr>";
        $html .= "<th class='th-sm'>Mã phòng thi</th>";
        $html .= "<th class='th-sm'>Địa điểm</th>";
        $html .= "<th class='th-sm'>Số lượng máy</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $html .= "<tr>";
                $html .= "<td class='maphongthi'>" . $value["maphongthi"] . "</td>";
                $html .= "<td class='diadiem'>" . $value["diadiem"] . "</td>";
                $html .= "<td class='soluongmay'>" . $value["soluongmay"] . "</td>";
                $html .= "</tr>";
            }
        }
        $html .= "</tbody><tfoot><tr>";
        $html .= "<th>Mã phòng thi</th><th>Địa điểm</th><th>Số lượng máy</th>";
        $html .= "</tr></tfoot></table>";

        return $html;
    }

    /**
     * Datalist các mã phòng thi
     * @return string
     */
    public function datalist_phongthi() {
        $size = sizeof($this->data);
        // Hiện datalist
        $html = "<datalist id='danhsachphongthi'>";
        for ($i = 0; $i < $size; $i++) {
            $a = json_encode($this->data[$i]);
            $b = json_decode($a);
            $html .= "<option value=\"".$b->maphongthi."\">Mã phòng thi: ".$b->maphongthi." --- Địa điểm: ".$b->mamonthi." --- Số lượng máy: ".$b->soluongmay;
        }
        $html .= "</datalist>";
        return $html;
    }

    /**
     * Hiện form thêm phòng thi.
     */
    public function addForm() {
        $html = "<form method='post' id='form_add' autocomplete='off'>
                  <div class='form-group'>
                    <label for='maphongthi_add'>Mã phòng thi</label>
                    <input type='text' class='form-control' id='maphongthi_add' name='maphongthi' placeholder='Nhập mã phòng thi muốn thêm' maxlength='20' minlength='1' required>
                  </div>
                  <div class='form-group'>
                    <label for='diadiem_add'>Địa điểm</label>
                    <input type='text' class='form-control' id='diadiem_add' name='diadiem' placeholder='Địa điểm' maxlength='50' minlength='1' required>
                  </div>
                  <div class='form-group'>
                    <label for='soluongmay_add'>Số lượng máy</label>
                    <input type='number' class='form-control' id='soluongmay_add' name='soluongmay' placeholder='Số lượng máy' min='1' required>
                  </div>";
        $html .= "<button type=\"button\" id='add-button' class=\"btn btn-primary\">Thêm</button></form>";
        return $html;
    }

    /**
     * Hiện form xóa phòng thi theo mã.
     */
    public function deleteForm() {
        $html = "<form method='post' id='form_delete' autocomplete='off'>
                  <div class='form-group'>
                    <label for='maphongthi_delete'>Mã phòng thi</label>
                    <input list='danhsachphongthi' type='text' class='form-control' id='maphongthi_delete' name='maphongthi' placeholder='Nhập mã phòng thi cần xóa' required>";
        $html .= "<button type='button' id='delete-button' class='btn btn-danger'>Xóa</button></form>";
        return $html;
    }

    /**
     * Hiện form sửa phòng thi.
     */
    public function editForm() {
        $html = "<form method='post' id='form_edit' autocomplete='off'>
                    <div class='form-group'>
                        <label for='maphongthi_edit'>Mã môn thi</label>
                        <input list='danhsachphongthi' type='text' class='form-control' id='maphongthi_edit' name='maphongthi' placeholder='Nhập mã phòng thi muốn sửa' maxlength='20' minlength='1' required>
                    </div>
                  <div class='form-group'>
                    <label for='diadiem_edit'>Địa điểm</label>
                    <input type='text' class='form-control' id='diadiem_edit' name='diadiem' placeholder='Địa điểm' maxlength='50' minlength='1' required>
                  </div>
                  <div class='form-group'>
                    <label for='tinchi_edit'>Số lượng máy</label>
                    <input type='number' class='form-control' id='soluongmay_edit' name='soluongmay' placeholder='Số lượng máy' min='1' required>
                  </div>";
        $html .= "<button type=\"button\" class=\"btn btn-primary\" id='edit-button'>Sửa</button></form>";
        return $html;
    }
}
// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash = document.getElementById("tablehash").innerText;

// Lấy dữ liệu từ bảng ban đầu
var _data = [];
var tbody_phongthi = document.getElementById('tablephongthi').childNodes[1];
for (var i = 0; i < tbody_phongthi.childElementCount; i++) {
    _data.push([tbody_phongthi.childNodes[i].childNodes[0].innerText, tbody_phongthi.childNodes[i].childNodes[1].innerText, tbody_phongthi.childNodes[i].childNodes[2].innerText]);
}

// Bật pagination
$(document).ready(function () {
    $('#tablephongthi').DataTable();
    $('.dataTables_length').addClass('bs-select');
});

let table = document.getElementById("table-container");

let datalist = document.getElementById("datalistcontainer");

// Hành vi cho nút thêm
let add_button = document.getElementById('add-button');
let add_form = document.getElementById("form_add");
add_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let maphongthi = document.getElementById("maphongthi_add").value; // Lấy mã phòng thi
    let diadiem = document.getElementById("diadiem_add").value; // Lấy địa điểm
    let soluongmay = document.getElementById("soluongmay_add").value; // Lấy số lượng máy
    // Kiểm tra
    if (maphongthi == "") { // Nếu trống mã phòng thi
        add_form.parentNode.insertBefore(createMessage("Mã phòng thi không được để trống.", -1), add_form.nextSibling);
    } else if (diadiem == "") { // Nếu trống địa điểm
        add_form.parentNode.insertBefore(createMessage("Địa điểm không được để trống.", -1), add_form.nextSibling);
    } else if (soluongmay == "" || soluongmay.indexOf(".") != -1 || soluongmay == "0") { // Nếu trống số lượng máy hoặc không đúng dạng
        add_form.parentNode.insertBefore(createMessage("Số lượng máy phải là một số nguyên dương lớn hơn 0.", -1), add_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("add=" + 1 + "&maphongthi=" + maphongthi + "&diadiem=" + diadiem + "&soluongmay=" + soluongmay);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Phòng thi được thêm thành công
                    success = 1;
                    message = response["success_msg"];
                } else { // Lỗi
                    success = -1;
                    message = response["error_msg"];
                }
                // Thêm vào sau form add
                add_form.parentNode.insertBefore(createMessage(message, success), add_form.nextSibling);
            }
        };
        // Làm trống form
        document.getElementById("maphongthi_add").value = "";
        document.getElementById("diadiem_add").value = "";
        document.getElementById("soluongmay_add").value = "";
    }
};

// Hành vi cho nút xóa
let delete_button = document.getElementById('delete-button');
let delete_form = document.getElementById("form_delete");
delete_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let maphongthi = document.getElementById("maphongthi_delete").value; // Lấy mã phòng thi
    // Kiểm tra
    if (maphongthi == "") { // Nếu trống mã phòng thi
        delete_form.parentNode.insertBefore(createMessage("Mã phòng thi không được để trống.", -1), delete_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("delete=" + 1 + "&maphongthi=" + maphongthi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Phòng thi được xóa thành công
                    success = 1;
                    message = response["success_msg"];
                } else { // Lỗi
                    success = -1;
                    message = response["error_msg"];
                }
                // Thêm vào sau form delete
                delete_form.parentNode.insertBefore(createMessage(message, success), delete_form.nextSibling);
            }
        };
        // Làm trống form
        document.getElementById("maphongthi_delete").value = "";
        // Xóa thông tin về môn đang xóa
        phongthidangxoa.innerText = "";
    }
};

// Hành vi cho nút sửa
var old_maphongthi = null; // Dùng để sửa mã phòng thi
let edit_button = document.getElementById('edit-button');
let edit_form = document.getElementById("form_edit");
edit_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let maphongthi = document.getElementById("maphongthi_edit").value; // Lấy mã phòng thi
    let diadiem = document.getElementById("diadiem_edit").value; // Lấy địa điểm
    let soluongmay = document.getElementById("soluongmay_edit").value; // Lấy số lượng máy
    // Kiểm tra
    if (maphongthi == "") { // Nếu trống mã phòng thi
        edit_form.parentNode.insertBefore(createMessage("Mã phòng thi không được để trống.", -1), edit_form.nextSibling);
    } else if (diadiem == "") { // Nếu trống địa điểm
        edit_form.parentNode.insertBefore(createMessage("Tên môn học không được để trống.", -1), edit_form.nextSibling);
    } else if (soluongmay == "" || soluongmay.indexOf(".") != -1 || soluongmay == "0") { // Nếu trống số lượng máy hoặc không đúng dạng
        edit_form.parentNode.insertBefore(createMessage("Số lượng máy phải là một số nguyên dương lớn hơn 0.", -1), edit_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("edit=" + 1 + "&maphongthicu=" + old_maphongthi + "&maphongthi=" + maphongthi + "&diadiem=" + diadiem + "&soluongmay=" + soluongmay);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Phòng thi được sửa thành công
                    success = 1;
                    message = response["success_msg"];
                } else { // Lỗi
                    success = -1;
                    message = response["error_msg"];
                }
                // Thêm vào sau form add
                edit_form.parentNode.insertBefore(createMessage(message, success), edit_form.nextSibling);
            }
        };
        // Làm trống form
        document.getElementById("maphongthi_edit").value = "";
        document.getElementById("diadiem_edit").value = "";
        document.getElementById("soluongmay_edit").value = "";
        old_maphongthi = null; // Reset mã phòng thi cũ
        // Xóa thông tin phòng đang sửa
        phongthidangsua.innerText = "";
    }
};

// Hàm tạo thông báo
function createMessage(_message, success) {
    var message = document.createElement("div");
    message.classList.add("alert");
    message.setAttribute("id", "message");
    message.setAttribute('role', "alert");
    message.innerHTML = _message;
    if (success == 1) { // Thông báo thành công
        message.classList.add("alert-success");
    } else if (success == -1) { // Thông báo thất bại
        message.classList.add("alert-danger");
    } else if (success == 0) { // Cảnh báo
        message.classList.add("alert-warning");
    }
    return message;
}

// Hàm dùng để refresh lại table sau khi sửa, xóa, thêm
function refresh_table() {
    // Bắt đầu Ajax
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "ajax.php?hash=" + table_hash, true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            if (table_hash != response['hash']) {
                table_hash = response['hash'];
                table.innerHTML = response["table"];
                // Refresh lại datalist
                datalist.innerHTML = response["datalist"];
                tbody_phongthi = document.getElementById('tablephongthi').childNodes[1];
                _data = []; // Xóa hết thông tin phòng thi cũ để thêm lại
                for (var i = 0; i < tbody_phongthi.childElementCount; i++) {
                    _data.push([tbody_phongthi.childNodes[i].childNodes[0].innerText, tbody_phongthi.childNodes[i].childNodes[1].innerText, tbody_phongthi.childNodes[i].childNodes[2].innerText]);
                }
                $('#tablephongthi').DataTable();
                $('.dataTables_length').addClass('bs-select');
            }
            // If hash match (data not changed), do nothing.
        }
    }
}

// Tự động refresh lại table sau 5 giây để dữ liệu đúng với trên database
setInterval(refresh_table, 5000);

// Hàm xóa element trong document theo id
function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

// Auto-complete (Tự động điền cho form sửa phòng thi dựa trên mã phòng thi)
var phongthidangsua = document.getElementById("phongthidangsua"); // Thông tin về phòng đang sửa
document.getElementById("maphongthi_edit").onblur = function () {
    var diadiem_edit = document.getElementById("diadiem_edit");
    var soluongmay_edit = document.getElementById("soluongmay_edit");

    // Tìm địa điểm và số lượng máy ứng với mã phòng thi
    var list_size = _data.length;
    for (var i = 0; i < list_size; i++) {
        if (_data[i][0] == this.value) {
            old_maphongthi = this.value;
            diadiem_edit.value = _data[i][1];
            soluongmay_edit.value = _data[i][2];
            phongthidangsua.innerText = "Mã phòng đang sửa: " + this.value + "\nĐịa điểm: " + diadiem_edit.value + "\nSố lượng máy: " + soluongmay_edit.value + "\n\n";
            return;
        }
    }
};

// Hiện phòng thi đang xóa
var phongthidangxoa = document.getElementById("phongthidangxoa"); // Thông tin về phòng đang xóa
document.getElementById("maphongthi_delete").onblur = function () {
    // Tìm địa điểm và số lượng máy ứng với mã phòng thi
    for (var i = 0; i < _data.length; i++) {
        if (_data[i][0] == this.value) {
            phongthidangxoa.innerText = "Mã phòng đang xóa: " + this.value + "\nĐịa điểm: " + _data[i][1] + "\nSố lượng máy: " + _data[i][2] + "\n\n";
            return;
        }
    }
    // Xóa thông tin về phòng đang xóa khi không trùng mã phòng.
    phongthidangxoa.innerText = "";
};
// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash = document.getElementById("tablehash").innerText;

// Lấy dữ liệu từ bảng ban đầu
var _data = [];
var tbody_monthi = document.getElementById('tablemonthi').childNodes[1];
for (var i = 0; i < tbody_monthi.childElementCount; i++) {
    _data.push([tbody_monthi.childNodes[i].childNodes[0].innerText, tbody_monthi.childNodes[i].childNodes[1].innerText, tbody_monthi.childNodes[i].childNodes[2].innerText]);
}

// Bật pagination
$(document).ready(function () {
    $('#tablemonthi').DataTable();
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
    let mamonthi = document.getElementById("mamonthi_add").value; // Lấy mã môn thi
    let tenmonthi = document.getElementById("tenmonthi_add").value; // Lấy tên môn thi
    let tinchi = document.getElementById("tinchi_add").value; // Lấy số tín chỉ
    // Kiểm tra
    if (mamonthi == "") { // Nếu trống mã môn thi
        add_form.parentNode.insertBefore(createMessage("Mã môn học không được để trống.", -1), add_form.nextSibling);
    } else if (tenmonthi == "") { // Nếu trống tên môn thi
        add_form.parentNode.insertBefore(createMessage("Tên môn học không được để trống.", -1), add_form.nextSibling);
    } else if (tinchi == "" || tinchi.indexOf(".") != -1 || tinchi == "0") { // Nếu trống tín chỉ hoặc không đúng dạng
        add_form.parentNode.insertBefore(createMessage("Số tín chỉ phải là một số nguyên dương lớn hơn 0.", -1), add_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("add=" + 1 + "&mamonthi=" + mamonthi + "&tenmonthi=" + tenmonthi + "&tinchi=" + tinchi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Môn học được thêm thành công
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
        document.getElementById("mamonthi_add").value = "";
        document.getElementById("tenmonthi_add").value = "";
        document.getElementById("tinchi_add").value = "";
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
    let mamonthi = document.getElementById("mamonthi_delete").value; // Lấy mã môn thi
    // Kiểm tra
    if (mamonthi == "") { // Nếu trống mã môn thi
        delete_form.parentNode.insertBefore(createMessage("Mã môn học không được để trống.", -1), delete_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("delete=" + 1 + "&mamonthi=" + mamonthi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Môn học được xóa thành công
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
        document.getElementById("mamonthi_delete").value = "";
        // Xóa thông tin về môn đang xóa
        mondangxoa.innerText = "";
    }
};

// Hành vi cho nút sửa
var old_mamonthi = null; // Dùng để sửa mã môn thi
let edit_button = document.getElementById('edit-button');
let edit_form = document.getElementById("form_edit");
edit_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let mamonthi = document.getElementById("mamonthi_edit").value; // Lấy mã môn thi
    let tenmonthi = document.getElementById("tenmonthi_edit").value; // Lấy tên môn thi
    let tinchi = document.getElementById("tinchi_edit").value; // Lấy số tín chỉ
    // Kiểm tra
    if (mamonthi == "") { // Nếu trống mã môn thi
        edit_form.parentNode.insertBefore(createMessage("Mã môn học không được để trống.", -1), edit_form.nextSibling);
    } else if (tenmonthi == "") { // Nếu trống tên môn thi
        edit_form.parentNode.insertBefore(createMessage("Tên môn học không được để trống.", -1), edit_form.nextSibling);
    } else if (tinchi == "" || tinchi.indexOf(".") != -1 || tinchi == "0") { // Nếu trống tín chỉ hoặc không đúng dạng
        edit_form.parentNode.insertBefore(createMessage("Số tín chỉ phải là một số nguyên dương lớn hơn 0.", -1), edit_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("edit=" + 1 + "&mamonthicu=" + old_mamonthi + "&mamonthi=" + mamonthi + "&tenmonthi=" + tenmonthi + "&tinchi=" + tinchi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Môn học được thêm thành công
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
        document.getElementById("mamonthi_edit").value = "";
        document.getElementById("tenmonthi_edit").value = "";
        document.getElementById("tinchi_edit").value = "";
        old_mamonthi = null; // Reset mã môn thi cũ
        // Xóa thông tin môn đang sửa
        mondangsua.innerText = "";
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
    ajaxEngine.open("GET", "ajax.php", true);
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
                tbody_monthi = document.getElementById('tablemonthi').childNodes[1];
                _data = []; // Xóa hết thông tin môn học cũ để thêm lại
                for (var i = 0; i < tbody_monthi.childElementCount; i++) {
                    _data.push([tbody_monthi.childNodes[i].childNodes[0].innerText, tbody_monthi.childNodes[i].childNodes[1].innerText, tbody_monthi.childNodes[i].childNodes[2].innerText]);
                }
                $('#tablemonthi').DataTable();
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

// Auto-complete (Tự động điền cho form sửa môn học dựa trên mã môn học)
var mondangsua = document.getElementById("mondangsua"); // Thông tin về môn đang sửa
document.getElementById("mamonthi_edit").onblur = function () {
    var tenmonhoc_edit = document.getElementById("tenmonthi_edit");
    var tinchi_edit = document.getElementById("tinchi_edit");

    // Tìm tên môn học và tín chỉ ứng với mã môn học
    var list_size = _data.length;
    for (var i = 0; i < list_size; i++) {
        if (_data[i][0] == this.value) {
            old_mamonthi = this.value;
            tenmonhoc_edit.value = _data[i][1];
            tinchi_edit.value = _data[i][2];
            mondangsua.innerText = "Mã môn đang sửa: " + this.value + "\nTên môn: " + tenmonhoc_edit.value + "\nTín chỉ: " + tinchi_edit.value + "\n\n";
            return;
        }
    }
};

// Hiện môn thi đang xóa
var mondangxoa = document.getElementById("mondangxoa"); // Thông tin về môn đang xóa
document.getElementById("mamonthi_delete").onblur = function () {
    // Tìm tên môn học và tín chỉ ứng với mã môn học
    for (var i = 0; i < _data.length; i++) {
        if (_data[i][0] == this.value) {
            mondangxoa.innerText = "Mã môn đang xóa: " + this.value + "\nTên môn: " + _data[i][1] + "\nTín chỉ: " + _data[i][2] + "\n\n";
            return;
        }
    }
    // Xóa thông tin về môn đang xóa khi không trùng mã môn.
    mondangxoa.innerText = "";
};
// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash = document.getElementById("tablehash").innerText;

// Lấy mã kỳ thi
let makythi = document.getElementById("kythi").innerText;

// Lấy dữ liệu từ bảng ban đầu
var _data = [];
var tbody_cathi = document.getElementById('tablecathi').childNodes[1];
for (var i = 0; i < tbody_cathi.childElementCount; i++) {
    _data.push([tbody_cathi.childNodes[i].childNodes[0].innerText, // Mã ca thi
                tbody_cathi.childNodes[i].childNodes[1].innerText, // Mã học phần
                tbody_cathi.childNodes[i].childNodes[2].innerText, // Tên môn thi
                tbody_cathi.childNodes[i].childNodes[3].innerText, // Ngày thi
                tbody_cathi.childNodes[i].childNodes[4].innerText, // Giờ bắt đầu
                tbody_cathi.childNodes[i].childNodes[5].innerText, // Giờ kết thúc
    ]);
}

// Bật pagination
$(document).ready(function () {
    $('#tablecathi').DataTable();
    $('.dataTables_length').addClass('bs-select');
});

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
    let mahocphan = document.getElementById("mahocphan_add").value; // Lấy mã học phần
    let ngaythi = document.getElementById("ngaythi_add").value; // Lấy ngày thi
    let giobatdau = document.getElementById("giobatdau_add").value; // Lấy giờ bắt đầu
    let gioketthuc = document.getElementById("gioketthuc_add").value; // Lấy giờ kết thúc
    // Kiểm tra
    if (mahocphan == "") { // Nếu trống tên môn thi
        add_form.parentNode.insertBefore(createMessage("Mã học phần không được để trống.", -1), add_form.nextSibling);
    } else if (ngaythi == "") { // Nếu trống ngày thi
        add_form.parentNode.insertBefore(createMessage("Ngày thi không được để trống.", -1), add_form.nextSibling);
    } else if (giobatdau == "") { // Nếu trống giờ bắt đầu
        add_form.parentNode.insertBefore(createMessage("Giờ bắt đầu không được để trống.", -1), add_form.nextSibling);
    } else if (gioketthuc == "") { // Nếu trống giờ kết thúc
        add_form.parentNode.insertBefore(createMessage("Giờ kết thúc không được để trống.", -1), add_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "/cathi/ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("add=" + 1 + "&kythi=" + makythi + "&mahocphan=" + mahocphan + "&ngaythi=" + ngaythi + "&giobatdau=" + giobatdau + "&gioketthuc=" + gioketthuc);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) {
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Ca thi được thêm thành công
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
        document.getElementById("mahocphan_add").value = "";
        document.getElementById("ngaythi_add").value = "";
        document.getElementById("giobatdau_add").value = "";
        document.getElementById("gioketthuc_add").value = "";
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
    let macathi = document.getElementById("macathi_delete").value; // Lấy mã ca thi
    // Kiểm tra
    if (macathi == "") { // Nếu trống mã ca thi
        delete_form.parentNode.insertBefore(createMessage("Mã ca thi không được để trống.", -1), delete_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "/cathi/ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("delete=" + 1 + "&kythi=" + makythi + "&macathi=" + macathi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Ca thi được xóa thành công
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
        document.getElementById("macathi_delete").value = "";
        // Xóa thông tin về ca thi đang xóa
        cathidangxoa.innerText = "";
    }
};

// Hành vi cho nút sửa
let edit_button = document.getElementById('edit-button');
let edit_form = document.getElementById("form_edit");
edit_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let macathi = document.getElementById("macathi_edit").value; // Lấy mã ca thi
    let mahocphan = document.getElementById("mahocphan_edit").value; // Lấy mã học phần
    let ngaythi = document.getElementById("ngaythi_edit").value; // Lấy ngày thi
    let giobatdau = document.getElementById("giobatdau_edit").value; // Lấy giờ bắt đầu
    let gioketthuc = document.getElementById("gioketthuc_edit").value; // Lấy giờ kết thúc
    // Kiểm tra
    if (macathi == "") { // Nếu trống mã ca thi
        edit_form.parentNode.insertBefore(createMessage("Mã ca thi không được để trống.", -1), edit_form.nextSibling);
    } else if (mahocphan == "") { // Nếu trống mã học phần
        edit_form.parentNode.insertBefore(createMessage("Mã học phần không được để trống.", -1), edit_form.nextSibling);
    } else if (ngaythi == "") { // Nếu trống ngày thi
        edit_form.parentNode.insertBefore(createMessage("Ngày thi không được để trống.", -1), edit_form.nextSibling);
    } else if (giobatdau == "") { // Nếu trống giờ bắt đầu
        edit_form.parentNode.insertBefore(createMessage("Giờ bắt đầu không được để trống.", -1), edit_form.nextSibling);
    } else if (gioketthuc == "") { // Nếu trống giờ kết thúc
        edit_form.parentNode.insertBefore(createMessage("Giờ kết thúc không được để trống.", -1), edit_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "/cathi/ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("edit=" + 1 + "&kythi=" + makythi + "&macathi=" + macathi + "&mahocphan=" + mahocphan + "&ngaythi=" + ngaythi + "&giobatdau=" + giobatdau + "&gioketthuc=" + gioketthuc);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Ca thi được sửa thành công
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
        document.getElementById("macathi_edit").value = "";
        document.getElementById("mahocphan_edit").value = "";
        document.getElementById("ngaythi_edit").value = "";
        document.getElementById("giobatdau_edit").value = "";
        document.getElementById("gioketthuc_edit").value = "";
        // Xóa thông tin ca thi đang sửa
        cathidangsua.innerText = "";
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
    ajaxEngine.open("GET", "/cathi/ajax.php?hash=" + table_hash + "&kythi=" + makythi, true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            if (table_hash != response['hash']) {
                table_hash = response['hash'];
                table.innerHTML = response["table"];
                // Refresh lại datalist
                let datalist = document.getElementById("danhsachcathi");
                datalist.innerHTML = response["danhsachcathi"];
                tbody_cathi = document.getElementById('tablecathi').childNodes[1];
                _data = []; // Xóa hết thông tin ca thi cũ để thêm lại
                for (var i = 0; i < tbody_cathi.childElementCount; i++) {
                    _data.push([tbody_cathi.childNodes[i].childNodes[0].innerText, // Mã ca thi
                        tbody_cathi.childNodes[i].childNodes[1].innerText, // Mã học phần
                        tbody_cathi.childNodes[i].childNodes[2].innerText, // Tên môn thi
                        tbody_cathi.childNodes[i].childNodes[3].innerText, // Ngày thi
                        tbody_cathi.childNodes[i].childNodes[4].innerText, // Giờ bắt đầu
                        tbody_cathi.childNodes[i].childNodes[5].innerText, // Giờ kết thúc
                    ]);
                }
                $('#tablecathi').DataTable();
                $('.dataTables_length').addClass('bs-select');
            }
            // Nếu trùng hash, không làm gì cả.
        }
    }
}

// Tự động refresh lại table sau 5 giây để dữ liệu đúng với trên database
setInterval(refresh_table, 10000);

// Hàm dùng để refresh lại datalist học phần
function refresh_datalist_hocphan() {
    var datalist = document.getElementById('danhsachhocphan');
    // Bắt đầu Ajax Engine và gửi request
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "/hocphan/ajax.php?danhsachhocphan=1", true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            datalist.innerHTML = response['danhsachhocphan'];
        }
    };
}
setInterval(refresh_datalist_hocphan, 10000);

// Hàm xóa element trong document theo id
function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

// Auto-complete (Tự động điền cho form sửa ca thi dựa trên mã ca thi)
var cathidangsua = document.getElementById("cathidangsua"); // Thông tin về ca thi đang sửa
document.getElementById("macathi_edit").onblur = function () {
    var mahocphan_edit = document.getElementById("mahocphan_edit");
    var ngaythi_edit = document.getElementById("ngaythi_edit");
    var giobatdau_edit = document.getElementById("giobatdau_edit");
    var gioketthuc_edit = document.getElementById("gioketthuc_edit");

    // Tìm thông tin ứng với mã ca thi
    var list_size = _data.length;
    for (var i = 0; i < list_size; i++) {
        if (_data[i][0] == this.value) {
            mahocphan_edit.value = _data[i][1];
            ngaythi_edit.value = _data[i][3];
            giobatdau_edit.value = _data[i][4];
            gioketthuc_edit.value = _data[i][5];
            cathidangsua.innerText = "Mã ca thi đang sửa: " + this.value + "\nMã học phần: " + mahocphan_edit.value + "\nTên môn thi: " + _data[i][2] + "\nNgày thi: " + ngaythi_edit.value + "\nGiờ bắt đầu: " + giobatdau_edit.value + "\nGiờ kết thúc: " + gioketthuc_edit.value + "\n\n";
            return;
        }
    }
};

// Hiện thông tin ca thi đang xóa
var cathidangxoa = document.getElementById("cathidangxoa"); // Thông tin về ca thi đang xóa
document.getElementById("macathi_delete").onblur = function() {
    // Tìm thông tin ứng với mã ca thi
    for (var i = 0; i < _data.length; i++) {
        if (_data[i][0] == this.value) {
            cathidangxoa.innerText = "Mã ca thi đang xóa: " + this.value + "\nMã học phần: " + _data[i][1] + "\nTên môn thi: " + _data[i][2] + "\nNgày thi: " + _data[i][3] + "\nGiờ bắt đầu: " + _data[i][4] + "\nGiờ kết thúc: " + _data[i][5] + "\n\n";
            return;
        }
    }
    // Xóa thông tin về ca thi đang xóa khi không trùng mã ca thi.
    cathidangxoa.innerText = "";
};
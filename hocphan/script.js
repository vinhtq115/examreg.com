// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash = document.getElementById("tablehash").innerText;

// Lấy dữ liệu từ bảng ban đầu
var _data = [];
var tbody_monthi = document.getElementById('tablehocphan').childNodes[1];
for (var i = 0; i < tbody_monthi.childElementCount; i++) {
    _data.push([tbody_monthi.childNodes[i].childNodes[0].innerText, tbody_monthi.childNodes[i].childNodes[1].innerText, tbody_monthi.childNodes[i].childNodes[2].innerText]);
}

// Bật pagination
$(document).ready(function () {
    $('#tablehocphan').DataTable({
        "sorting": [[1, "asc"]] // Mặc định sort theo tên môn thi
    });
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
    let mamonthi = document.getElementById("mamonthi_add").value; // Lấy mã môn thi
    let mahocphan = document.getElementById("mahocphan_add").value; // Lấy tên môn thi
    // Kiểm tra
    if (mamonthi == "") { // Nếu trống mã môn thi
        add_form.parentNode.insertBefore(createMessage("Mã môn thi không được để trống.", -1), add_form.nextSibling);
    } else if (mahocphan == "") { // Nếu trống tên môn thi
        add_form.parentNode.insertBefore(createMessage("Mã học phần không được để trống.", -1), add_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("add=" + 1 + "&mamonthi=" + mamonthi + "&mahocphan=" + mahocphan);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table(); // Refresh lại table
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Học phần được thêm thành công
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
        document.getElementById("mahocphan_add").value = "";
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
    let mahocphan = document.getElementById("mahocphan_delete").value; // Lấy mã học phần
    // Kiểm tra
    if (mahocphan == "") { // Nếu trống mã môn thi
        delete_form.parentNode.insertBefore(createMessage("Mã học phần không được để trống.", -1), delete_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("delete=" + 1 + "&mahocphan=" + mahocphan);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Học phần được xóa thành công
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
        document.getElementById("mahocphan_delete").value = "";
        // Xóa thông tin về môn đang xóa
        hocphandangxoa.innerText = "";
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

// Hàm dùng để refresh lại table sau khi xóa, thêm học phần
let table = document.getElementById("table-container");
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
                //refresh_datalist("danhsachmonhoc", 0);
                refresh_datalist_hocphan(); // Học phần
                refresh_datalist_monthi(); // Môn thi
                $('#tablemonthi').DataTable();
                $('.dataTables_length').addClass('bs-select');
            }
            // If hash match (data not changed), do nothing.
        }
    }
}

// Hàm dùng để refresh lại datalist học phần
function refresh_datalist_hocphan() {
    var datalist = document.getElementById('danhsachhocphan');
    datalist.innerHTML = ""; // Xóa datalist cũ
    var res = new Set();
    var table_body = table.firstElementChild.firstElementChild.nextElementSibling;
    var list_size = table_body.childElementCount;
    for (var i = 0; i < list_size; i++) {
        var row = table_body.childNodes[i];
        var opt = document.createElement("option");
        opt.setAttribute("value", row.childNodes[2].innerText);
        res.add(opt.outerHTML);
    }
    var arr = Array.from(res);
    for (var i = 0; i < arr.length; i++) {
        datalist.innerHTML += arr[i];
    }
}

// Hàm dùng để refresh lại datalist môn thi
function refresh_datalist_monthi() {
    var datalist = document.getElementById('danhsachmonhoc');
    // Bắt đầu Ajax Engine và gửi request
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "/monthi/ajax.php?danhsachmonthi=1", true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            //var datalistcontainer = document.getElementById('datalistcontainer');
            datalist.innerHTML = response['monthi'];
        }
    };
}

// Tự động refresh lại table sau 5 giây để dữ liệu đúng với trên database
setInterval(refresh_table, 5000);

// Tự động refresh lại datalist sau 5 giây để dữ liệu đúng với trên database
setInterval(refresh_datalist_monthi, 5000);

// Hàm xóa element trong document theo id
function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

// Auto-complete (Tự động điền cho form thêm học phần dựa trên mã môn học)
document.getElementById("mamonthi_add").onblur = function () {
    if (this.value != "")
        document.getElementById("mahocphan_add").value = this.value + " ";
    else
        document.getElementById("mahocphan_add").value = "";
};

// Hiện học phần đang xóa
var hocphandangxoa = document.getElementById("hocphandangxoa"); // Thông tin về học phần đang xóa
document.getElementById("mahocphan_delete").onblur = function () {
    // Tìm thông tin mã học phần
    var list_size = _data.length;
    for (var i = 0; i < list_size; i++) {
        if (_data[i][2] == this.value) {
            hocphandangxoa.innerText = "Mã học phần đang xóa: " + this.value + "\nTên môn: " + _data[i][1] + "\nMã môn thi: " + _data[i][0] + "\n\n";
            return;
        }
    }
    // Xóa thông tin về môn đang xóa khi không trùng mã môn.
    hocphandangxoa.innerText = "";
};
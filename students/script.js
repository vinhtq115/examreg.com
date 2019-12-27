// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash_sv = document.getElementById("table1hash").innerText;
var table_hash_svhhp = document.getElementById("table2hash").innerText;

let table_sv = document.getElementById("table-container1");
let table_svhhp = document.getElementById("table-container2");

// Bật pagination
$(document).ready(function () {
    $('#tablesinhvien').DataTable(); // Table sinh viên
    $('#tablesvhhp').DataTable(); // Table học sinh học học phần
    $('.dataTables_length').addClass('bs-select');
});

// Hàm dùng để refresh lại table sinh viên
function refresh_table_sv() {
    // Bắt đầu Ajax
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "/students/ajax.php?hash1=" + table_hash_sv, true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            if (table_hash_sv != response['hash']) {
                table_hash_sv = response['hash'];
                table_sv.innerHTML = response["table"];
                // Bật lại pagination
                $('#tablesinhvien').DataTable();
                $('.dataTables_length').addClass('bs-select');
            }
            // Nếu trùng hash, không làm gì cả.
        }
    }
}

// Hàm dùng để refresh lại table sinh viên học học phần
function refresh_table_svhhp() {
    // Bắt đầu Ajax
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "/students/ajax.php?hash2=" + table_hash_svhhp, true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            if (table_hash_svhhp != response['hash']) {
                table_hash_svhhp = response['hash'];
                table_svhhp.innerHTML = response["table"];
                // Bật lại pagination
                $('#tablesvhhp').DataTable();
                $('.dataTables_length').addClass('bs-select');
            }
            // Nếu trùng hash, không làm gì cả.
        }
    }
}

// Tự động refresh lại table sau 5 giây để dữ liệu đúng với trên database
setInterval(refresh_table_sv, 5000);
setInterval(refresh_table_svhhp, 5000);
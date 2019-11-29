<?php


class PDOData {
    protected $db = null; // Đối tượng PDO
//    private $host = "localhost"; // SQL hostname
//    private $dbname = "web"; // Database name
//    private $username = "test"; // Username for connecting database
//    private $password = "123456"; // Password for connecting database
    private $host = "localhost"; // SQL hostname
    private $dbname = "web"; // Database name
    private $username = "test"; // Username for connecting database
    private $password = "123456"; // Password for connecting database

    /**
     * Constructor
     */
    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8", $this->username, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Deconstructor
     */
    public function __destruct()
    {
        // Close connection
        try {
            $this->db = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Thực hiện câu lệnh truy vấn.
     * @param $query: Câu lệnh SQL (SELECT)
     * @return array: Mảng các bản ghi
     */
    public function doQuery($query) {
        $ret = array(); // Return array

        try {
            $stmt = $this->db->query($query);
            if ($stmt) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $ret[] = $row;
                }
            }
        } catch (PDOException $e) {
            echo $query;
        }

        return $ret;
    }

    /**
     * Thực hiện truy vấn theo câu lệnh chuẩn bị trước.
     * @param $queryTemplate: Mẫu câu truy vấn
     * @param $params: Mảng các tham số cho truy vấn
     * @return array: Mảng các bản ghi
     */
    public function doPreparedQuery($queryTemplate, $params) {
        $ret = array(); // Mảng chứa kết quả

        try {
            $stmt = $this->db->prepare($queryTemplate);
            foreach ($params as $k=>$v) {
                $stmt->bindValue($k+1, $v);
            }
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ret[] = $row;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $ret;
    }

    /**
     * Chạy lệnh SQL (INSERT, DELETE, UPDATE,...) và trả về số lượng bản ghi được cập nhật.
     * @param $sql: SQL statement
     * @return int: Number of updated records.
     */
    public function doSql($sql) {
        try {
            $count = $this->db->exec($sql);
        } catch (PDOException $e) {
            $count = -1;
        }
        return $count;
    }
}


<?php 
    class  connect {
        var $db = null;
        public function __construct() {
            
            // Đường dẫn đến database trên local
            $dsn = 'mysql:host=localhost;dbname=ecoshop';
            $user = 'root';
            $pass = '';

            // Đường dẫn đến database trên infinityfree
            // $dsn = 'mysql:host=lsql203.infinityfree.com;dbname=if0_40094930_ecoshop';
            // $user = 'if0_40094930';
            // $pass = 'haidang2k4';
            try{
                $this->db = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
            }catch(\Throwable $th) {
                // ném lỗi
                echo "Kết nối không thành công";
                echo $th;
            }
        }

        function getList($select) {
            $result = $this->db->query($select); // trả về nhiều dòng;
            return $result;
        }

        function getInstance($select) {
            $results = $this->db->query($select); // trả về 1 dòng;
            // do trả về 1 dòng nên fetch luôn để lấy dữ liệu
            $result = $results->fetch();
            return $result;
        } 


        // Phương thức thực thi câu lệnh insert, update, delete (exec)
        function exec($query) {
            if (!$this->db) {
                throw new Exception("Database connection not available");
            }
            $result = $this->db->exec($query);
            if ($result === false) {
                $errorInfo = $this->db->errorInfo();
                throw new Exception("Database error: " . $errorInfo[2]);
            }
            return $result;
        }

        // phương thức prepare
        function execp($query) {
            $statement = $this->db->prepare($query);
            return $statement;
        }

    }
?>
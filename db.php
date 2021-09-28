<?php
    class Database{
        private $dsn = "mysql:host=localhost;dbname=oop_crud";
        private $user = "root";
        private $pass = "";
        private $conn;

        function __construct(){
            try{
                $this->conn = new PDO($this->dsn,$this->user,$this->pass);
                //echo "success";
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function insert($firstname, $lastname, $email){
            $sql = "INSERT INTO users(firstname,lastname,email)VALUES(:fname,:lname,:email)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array('fname'=>$firstname,'lname'=>$lastname,'email'=>$email));
            return true;
        }

        public function read(){
            $data = array();
            $sql = "SELECT * FROM users";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
                $data[] = $row;
            }
            return $result;
        }

        public function update($firstname, $lastname, $email, $id){
            $sql = "UPDATE users SET firstname=:fname,lastname=:lname,email=:email WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array('fname'=>$firstname,'lname'=>$lastname,'email'=>$email, 'id'=>$id));
            return true;
        }

        public function getUserById($id){
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array('id'=>$id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function delete($id){
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array('id'=>$id));
            return true;
        }

        public function totalRowCount(){
            $sql = "SELECT * FROM users";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $t_rows = $stmt->rowCount();
            return $t_rows;
        }
    }
?>
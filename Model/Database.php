<?php
class Database {
    private $db_host='localhost';
    private $db_user='root';
    private $db_pass='';
    private $db_name='bangdiem';
    
    private $con=NULL;
    private $result;

    public function connect() {
        if($this->con==NULL){
            $this->con= mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            mysqli_set_charset($this->con, "utf8");
        }
    }
    public function disconnect() {
        if ($this->con!=NULL) {
            mysqli_close($this->con);
        }
    }
    public function insert($table,$data=NULL) {
        if($data!=NULL){
            $fields="";
            $values="";
            foreach ($data as $key => $value) {
                $fields.=$key.',';
                $values.="'". mysqli_escape_string($this->con,$value)."',";
            }
            $fields=rtrim($fields,',');
            $values=rtrim($values,',');

            $sql='INSERT INTO '.$table.' ('.$fields.') VALUES('.$values.')';
            if (mysqli_query($this->con, $sql)) {
                return TRUE;
            }
        }
        return FALSE;
    }
    public function getlist($sql) {
        $result=  mysqli_query($this->con, $sql);
        if(!$result){
            return FALSE;
        }
        $return=array();
        while ($row=mysqli_fetch_assoc($result)){
            $return[]=$row;
        }
        mysqli_free_result($result);
        $this->disconnect();
        return $return;
    }
    public function select($table,$where,$fields=NULL) {
        if ($where=='all') {
            $sql='SELECT * FROM '.$table;
            if (!$result) {
            die('Cau truy va bi sai');
            }
            
        }else{
            if ($fields==NULL) {
                $sql='SELECT * FROM '.$table.' WHERE '.$where;
            }else{
                $column=implode(','.$fields);
                $sql='SELECT '.$column.' FROM '.$table.' WHERE '.$where;
            }
        }
        $result=  mysqli_query($this->con, $sql);
        if (!$result) {
            die('Cau truy va bi sai');
        }
        $return=array();
        while ($row=mysqli_fetch_assoc($result)){
            $return[]=$row;
        }
        mysqli_free_result($result);
        $this->disconnect();
        return $return;
    }
    public function select_one($table,$where,$fields=NULL) {
        if ($where=='all') {
            $sql='SELECT * FROM '.$table.' LIMIT 1';
            if (!$result) {
            die('Cau truy va bi sai');
            }
            
        }else{
            if ($fields==NULL) {
                $sql='SELECT * FROM '.$table.' WHERE '.$where.' LIMIT 1';
            }else{
                $column=implode(',',$fields);
                $sql='SELECT '.$column.' FROM '.$table.' WHERE '.$where.' LIMIT 1';
            }
        }
        echo $sql;
        $result= mysqli_query($this->con, $sql);
        if (!$result) {
            die ("sai cau truy van");
        }
        $row=mysqli_fetch_assoc($result);
        return $row;
    }
    public function delete($table,$where) {
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->con, $sql);
    }
    public function update($table,$data,$where) {
        $sql = '';
        foreach ($data as $key => $value){
            $sql .= "$key = '".mysqli_escape_string($this->con,$value)."',";
        }
        $sql = 'UPDATE '.$table. ' SET '.trim($sql, ',').' WHERE '.$where;

        return mysqli_query($this->con, $sql);
    }
    public function show_error() {
        return mysqli_error($this->con);
    }
    
    public function count_num_row($sql) {
        $result=mysqli_query($this->con, $sql);
        if ($result) {
            return mysqli_num_rows($result);
        }
        return 0;
    }
    public function is_user($username,$password) {
        $pass=  md5($password);
        $sql="SELECT * FROM user WHERE username='$username' AND password='$pass'";
        if ($this->count_num_row($sql)>0) {
            return TRUE;
        }
        return FALSE;
    }
    public function get_user($username) {
        $sql="SELECT * FROM user WHERE username='$username'";
        $result=  mysqli_query($this->con, $sql);
        if (!$result) {
            die(" Lỗi Truy vấn");
        }
        return mysqli_fetch_assoc($result);
    }
    public function count($table)
    {
        $sql=$table!='monhoc'?"SELECT id FROM $table":"SELECT ma FROM $table";
        return $this->count_num_row($sql);
    }
}

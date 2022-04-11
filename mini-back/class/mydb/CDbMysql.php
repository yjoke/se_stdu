<?php
$DB = array("host"		=> "localhost",
			"user"		=> "test1",
			"password"	=> "test1",
			"dbName"	=> "test1");
define("DB", serialize($DB));
?>
<?php
class CDbMysql {
    // 构造函数
    function __construct($db = DB) {
		if(is_string($db))
			$db = unserialize($db);
        $this->host		= $db["host"];
		$this->user		= $db["user"];	
		$this->password = $db["password"];
        $this->dbName	= $db["dbName"];
        $this->conn     = null;
    }
    // 析构函数, 自动结束连接
    function __destruct() {
        if($this->conn) {
            $this->conn->close();
        }
    }
    
    // 连接指定数据库
    function connect() {
        if($this->conn)
            $this->conn->close();
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbName);
		return $this->conn? TRUE : FALSE;
    }
    function flag() {
        return $this->conn;
    }
    // 结束连接
	function close() {
		if($this->conn) {
            if ($this->conn->close()) {
                $this->conn = null;
                return TRUE;
            } else {
                return FALSE;
            }
		}
	}
    
    // 查询
    function doQuery($sql) {
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
	// 插入
    function doInsert($sql) {
        $this->conn->query($sql);
        return $this->conn->affected_rows == 1? TRUE : FALSE;
    }
	
	// 删除
	function doDelete($sql) {
        $this->conn->query($sql);
        return $this->conn->affected_rows == 1? TRUE : FALSE;
    }
	
	// 更新
	function doUpdate($sql) {
        $this->conn->query($sql);
        return $this->conn->affected_rows == 1? TRUE : FALSE;
    }
    
    private $host;
    private $user;
    private $password;
    private $dbName;
    private $conn;
}
?>

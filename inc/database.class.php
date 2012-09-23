<?
class Database {
	
	const HOST = "localhost";
	const USER = "root";
	const PWD = "s7lZPry0";
	const DATABASE = "session1";
	const PREFIX = "session_";
	private $connID;
	public $insertID;
	
	public function __construct() {
		$this->connID = mysqli_connect(self::HOST, self::USER, self::PWD, self::DATABASE);
	}
	public function __destruct() {
		mysqli_close($this->connID);
	}
	
	public function select($table, $fields = "*", $add = NULL) {
		
		$query = "SELECT $fields FROM ".self::PREFIX.$table;
		if($add !== NULL)
			$query .= " ".$add;
		
		$result = mysqli_query($this->connID, $query);
		
		if($result) {
			$return = array();
			while($a = mysqli_fetch_assoc($result))
				array_push($return, $a);
		} else
			$return = false;
		
		return $return;
		
	}
	
	public function field($table, $field, $add) {
	
		$query = "SELECT $field FROM ".self::PREFIX."$table $add";
		
		$result = mysqli_query($this->connID, $query);
		
		$return = mysqli_fetch_assoc($result);
		
		return $return[$field];
		
	}
	
	public function update($table, $data, $add = NULL) {
		
		$query = "UPDATE ".self::PREFIX.$table;
		
		$dataArray = array();
		foreach($data as $name => $value)
			array_push($dataArray, "$name = '$value'");
		
		$query .= " SET ".implode(", ", $dataArray);
		
		if($add !== NULL)
			$query .= " $add";
		
		return mysqli_query($this->connID, $query);
		
	}
	
	public function insert($table, $data) {
		
		$fields = implode(", ", array_keys($data));
		$values = implode(", ", $data);
		
		$query = "INSERT INTO ".self::PREFIX.$table." ($fields) VALUES ($values)";
		
		$return = mysqli_query($this->connID, $query);
		$this->insertID = mysqli_insert_id($this->connID);
		
		return $return;
		
	}
	
	public function delete($table, $add) {
		
		$query = "DELETE FROM ".self::PREFIX.$table." ".$add;
		
		return mysqli_query($this->connID, $query);
	}
	
	public function getOption($name) {
		
		return $this->field("options", "value", "WHERE name='$name'");
		
	}
	
	public function setOption($name, $value) {
		
		return $this->update("options", array("value" => $value), "WHERE name ='$name'");
		
	}
	
}

$db = new Database();
?>

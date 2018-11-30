<?php
include_once('constants.php');
class database {
    private $RDBMType = DB_TYPE;  //In the PHP PDO format
    private $username = DB_USER;
    private $password = DB_PASS;
    private $dbhost = DB_HOST;
    private $database =DB_DATABASE;
  public $LastInsertId=0;

    function __construct() {
        //Connection string
   	$this->pdo = new PDO($this->RDBMType . ":host=" . $this->dbhost . ";dbname=" . $this->database, $this->username,
   	$this->password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
     }
     public function Disconnect(){
            $this->pdo = null;
            $this->isConnected = false;
        }

     //Initiates a transaction.
     public  function beginTransaction()
     {
      	  $this->pdo->beginTransaction();
     }

     //Commits a transaction.
     public function commitTransaction(){
      $this->pdo->commit();
    }

   // Roll back a transaction.
    public function rollbackTransaction()
    {
      $this->pdo->rollBack();
    }

      public function getRow($query, $params=array())
     	   {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                return $stmt->fetch();
           }
       public function getCount($query, $params=array())
     	   {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                return $stmt->rowCount();
           }
      	public function getRows($query, $params=array()){
      	        $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll();
            }

       public function getObjs($query, $params=array()){
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }

        public function getCols($params=array()){
                $query   ="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                $output = array();
        	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            		$output[] = $row['COLUMN_NAME'];
        	}
        	return $output;
              //  return $stmt->fetchAll();
            }

        public function insertRow($query, $params){
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                return $stmt->rowCount();
              //  return  pdo->lastInsertId();
              }

        public function updateRow($query, $params){
            return $this->insertRow($query, $params);
        }
        public function deleteRow($query, $params){
            return $this->insertRow($query, $params);
        }
        public function Execute($query){
             return $this->pdo->exec($query);
           }

        public function phpAlert($msg) {
    	echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
}
$db = new database;
function redirect($location){
    exit(header("location: $location"));
}
function redirectT($location,$time){
   exit (header("refresh: $time; url=$location"));
}
function shortenText($text,$chars = 400){
    $text = $text." ";
    $text = substr($text,0,$chars);
    $text = substr($text,0,strrpos($text,' '));
    $text = $text."...";
    return $text;
}
?>


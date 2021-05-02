<?php 
require_once(dirname(__FILE__)."/../database.php");

class Db {
	protected $dbh;
	public function __construct($dbh = null){
		if(!$dbh){
			try {
				$this->dbh = new PDO(
					"mysql:dbname=".DB_NAME.
					";host=".DB_HOST, DB_USER, DB_PASS
				);
			} catch(PDOException $e){
				echo "接続失敗:". $e->getMessage(). "\n";
				exit();
			}
		}else {
			$this->dbh = $dbh;
		}
	}
	// 複数モデルを使用する場合2つ目以降再接続しない
	public function get_db_handler(){
		return $this->dbh;
	}
}


?>
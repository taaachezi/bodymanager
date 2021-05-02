<?php
 require_once(ROOT_PATH."/Models/Db.php");
 class Favorite extends Db {
 	private $table = "favorites";
 	public function __construct($dbh = null){
 		parent::__construct($dbh);
 	}
 	public function insert_favorite($user_id, $item_id) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "INSERT INTO $this->table (user_id, item_id) VALUES (:user_id, :item_id)";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id",$user_id, PDO::PARAM_INT);
 			$stmt->bindValue(":item_id",$item_id, PDO::PARAM_INT);
 			$params = array("user_id"=>$user_id, "item_id"=>$item_id);
 			$stmt->execute($params);
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function delete_favorite($user_id, $item_id) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "DELETE FROM $this->table WHERE user_id = :user_id AND item_id = :item_id";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id",$user_id, PDO::PARAM_INT);
 			$stmt->bindValue(":item_id",$item_id, PDO::PARAM_INT);
 			$stmt->execute();
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function find_all($user_id) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "SELECT $this->table.*, items.name FROM $this->table JOIN items ON items.id = $this->table.item_id WHERE $this->table.user_id = :user_id";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id",$user_id, PDO::PARAM_INT);
 			$stmt->execute();
 			$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
 			return $favorites;
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 }
?>
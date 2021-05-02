<?php
 require_once(ROOT_PATH."/Models/Db.php");
 class Intake extends Db {
 	private $table = "intakes";
 	public function __construct($dbh = null){
 		parent::__construct($dbh);
 	}
 	public function insert_intake($post){
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$created = $post["created"];
 			$user_id = $post["user_id"];
 			$quantity = $post["quantity"];
 			$item_id = $post["all_item"] ?? $post["favorite_item"];
 			$sql = "INSERT INTO $this->table (user_id,item_id,quantity,created_at) VALUES (:user_id, :item_id,:quantity,:created_at)";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue("user_id",$user_id,PDO::PARAM_INT);
 			$stmt->bindValue("item_id",$item_id,PDO::PARAM_INT);
 			$stmt->bindValue("quantity",$quantity,PDO::PARAM_STR);
 			$stmt->bindValue("created_at",$created,PDO::PARAM_STR);
 			$params = array(":user_id"=>$user_id, ":item_id"=>$item_id,":quantity"=>$quantity,":created_at"=>$created);
 			$stmt->execute($params);
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function check_intake($post){
 		$errors = null;
 		$quantity = $post["quantity"] ?? "";
 		$item_id = $post["all_item"] ?? $post["favorite_item"] ?? "";
 		if (empty($quantity)) {
 			$errors["quantity_empty"] = "数量を選択してください";
 		}
 		if (empty($item_id)) {
 			$errors["item_empty"] = "食材を選択してください";
 		}
 		return $errors;
 	}
 	public function delete_intake($id) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "DELETE FROM $this->table WHERE id = :id";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":id", $id, PDO::PARAM_INT);
 			$stmt->execute();
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function find_all($user_id,$current_time) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "SELECT intakes.id, intakes.user_id, intakes.quantity, items.calorie, items.protein, items.fat, items.carbo, items.name FROM $this->table JOIN items ON intakes.item_id = items.id WHERE intakes.user_id = :user_id AND created_at = :created_at ";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
 			$stmt->bindValue(":created_at", $current_time, PDO::PARAM_STR);
 			$stmt->execute();
 			$intakes_all = $stmt->fetchAll(PDO::FETCH_ASSOC);
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 		return $intakes_all;
 	}
 }
?>
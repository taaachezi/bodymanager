<?php
 require_once(ROOT_PATH."/Models/Db.php");
 class Item extends Db {
 	private $table = "items";
 	public function __construct($dbh = null){
 		parent::__construct($dbh);
 	}
 	public function check_form($post){
 		$name = $post["name"];
 		$protein = $post["protein"];
 		$carbo = $post["carbo"];
 		$fat = $post["fat"];
 		$user_id = $post["user_id"];
 		$errors = array();
 		if (!isset($post["id"])) {
 			try{
	 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 			$sql = "SELECT name FROM $this->table WHERE user_id = :user_id AND name = :name";
	 			$stmt = $this->dbh->prepare($sql);
	 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
	 			$stmt->bindValue(":name", $name, PDO::PARAM_STR);
	 			$stmt->execute();
	 			$is_name = $stmt->fetchColumn();
 			}catch(PDOExeception $e) {
 				echo "接続エラー", $e->getMessage();
 			}
 		}else{
 			$is_name = "";
 		}
 		if (empty($name)) {
 			$errors["name_empty"] = "食材名を入力してください";
 		}elseif ($is_name == $name) {
 			$errors["name_have"] = "登録済み食材です";
 		}
 		if (empty($protein)) {
 			$errors["protein_empty"] = "たんぱく質量を入力してください";
 		}elseif (!is_numeric($protein)) {
 			$errors["protein_num"] = "数字で入力してください";
 		}
 		if (empty($carbo)) {
 			$errors["carbo_empty"] = "炭水化物量を入力してください";
 		}elseif(!is_numeric($carbo)) {
 			$errors["carbo_num"] = "数字で入力してください";
 		}
 		if(empty($fat)) {
 			$errors["fat_empty"] = "脂質量を入力してください";
 		}elseif (!is_numeric($fat)) {
 			$errors["fat_num"] = "数字で入力してください";
 		}
 		return $errors;
 	}
 	public function insert_item($post){
 		$name = $post["name"];
 		$protein = $post["protein"];
 		$carbo = $post["carbo"];
 		$fat = $post["fat"];
 		$user_id = $post["user_id"];
 		$calorie = round($protein*4+$carbo*4+$fat*9,1);
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "INSERT INTO $this->table (name,calorie,protein,carbo,fat,user_id) VALUES (:name, :calorie, :protein, :carbo, :fat, :user_id)";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
 			$params = array(":name"=>$name, ":calorie"=>$calorie, ":protein"=>$protein, ":carbo"=>$carbo, ":fat"=>$fat, ":user_id"=>$user_id);
 			$stmt->execute($params);
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function find_all($user_id) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "SELECT * FROM $this->table WHERE user_id = :user_id";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
 			$stmt->execute();
 			$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
 			return $items;
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function find_search($post) {
 		$user_id = $post["user_id"];
 		$search = $post["search"];
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "SELECT * FROM $this->table WHERE user_id = :user_id AND name LIKE '%".$search."%'";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
 			// $stmt->bindParam(":search", $search, PDO::PARAM_STR);
 			$stmt->execute();
 			$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
 			return $items;
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function update_item($post){
 		$name = $post["name"];
 		$protein = $post["protein"];
 		$carbo = $post["carbo"];
 		$fat = $post["fat"];
 		$id = $post["id"];
 		$calorie = round($protein*4+$carbo*4+$fat*9,1);
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "UPDATE $this->table SET name = :name, protein=:protein, carbo = :carbo, fat = :fat, calorie = :calorie WHERE id = :id";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":id", $id, PDO::PARAM_INT);
 			$stmt->execute(array("name"=>$name, "protein"=>$protein, "carbo"=>$carbo, "fat"=>$fat, "calorie"=>$calorie, "id"=>$id));
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function delete_item($id) {
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

 }
?>
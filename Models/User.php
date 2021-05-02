<?php
 require_once(dirname(__FILE__)."/Db.php");
 class User extends Db {
 	private $table = "users";
 	private $admins_table = "admins";
 	public function __construct($dbh = null){
 		parent::__construct($dbh);
 	}
 	public function insert_user($post) {
 		// setAttribute:エラーレポート　成功時ture 失敗時false
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$name = $post["name"];
 			$email = $post["email"];
 			$password = password_hash($post["password"],PASSWORD_DEFAULT);
 			$sql = "INSERT INTO $this->table (name, email, password) VALUES (:name, :email, :password)";
 			$stmt = $this->dbh->prepare($sql);
 			$params = array(":name"=>$name, ":email"=>$email, ":password"=>$password);
 			$stmt->execute($params);
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function user_check($post) {
 		$email = $post["email"];
 		$name = $post["name"];
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		$sql = "SELECT * FROM $this->table WHERE email = :email AND name = :name AND role IN(0,2)";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":email",$email, PDO::PARAM_STR);
	 		$stmt->bindValue(":name",$name, PDO::PARAM_STR);
	 		$stmt->execute();
	 		$user = $stmt->fetch(PDO::FETCH_ASSOC);
	 		return $user;
	 	}catch(PDOExeception $e) {
	 		echo "接続エラー", $e->getMessage();
	 	}
 		return $user;
 	}
 	public function registration_check($post) {
 		$errors = array();
 		$name = $post["name"];
 		$email = $post["email"];
 		$password = $post["password"];
 		$password_conf = $post["password_conf"];
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		$sql = "SELECT email FROM $this->table WHERE email = :email ";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":email",$email,PDO::PARAM_STR);
	 		$stmt->execute();
	 		$user_email = $stmt->fetchColumn();

	 		$sql = "SELECT name FROM $this->table WHERE name = :name";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":name",$name,PDO::PARAM_STR);
	 		$stmt->execute();
	 		$user_name = $stmt->fetchColumn();
	 	}catch(PDOExeception $e) {
	 		echo "接続エラー", $e->getMessage();
	 	}
 		// nameが空、10字
 		if (empty($name)) {
 			$errors["name_empty"] = "ユーザ名は必須入力です";
 		}elseif(mb_strlen($name)>10) {
 			$errors["name_length"] = "10文字以内で入力してください";
 		}elseif($name == $user_name) {
 			$errors["name"] = "このユーザ名は登録済みです";
 		}
 		// email空欄、
 		if (empty($email)) {
 			$errors["email_empty"] = "メールアドレスは必須入力です";
 		}elseif($email == $user_email) {
 			$errors["email"] = "このメールアドレスは登録済みです";
 		}
 		// パスワード
 		if ($password_conf !== $password) {
 			$errors["password_conf"] = "パスワードが一致しません";
 		}elseif(empty($password)){
 			$errors["password_empty"] = "パスワードは必須入力です";
 		}elseif(mb_strlen($password)<6){
 			$errors["password_length"] = "パスワードは6文字以上です";
 		}
 		return $errors;
 	}
 	public function login_check($post,$user) {
 		$errors = array();
 		$name = $post["name"];
 		$email = $post["email"];
 		$password = $post["password"];
 		// nameが空、10字
 		if (empty($name)) {
 			$errors["name_empty"] = "ユーザ名は必須入力です";
 		}elseif(mb_strlen($name)>10) {
 			$errors["name_length"] = "10文字以内で入力してください";
 		}
 		// email空欄、
 		if (empty($email)) {
 			$errors["email_empty"] = "メールアドレスは必須入力です";
 		}elseif(empty($user)){
 			$errors["email_non"] = "メールアドレスまたはユーザ名に誤りがあります";
 		}elseif(!password_verify($password, $user["password"])){
 			$errors["password_non"] = "パスワードが違います";
 		}

 		if(empty($password)){
 			$errors["password_empty"] = "パスワードは必須入力です";
 		}

 		return $errors;
 	}
 	public function update_password($post) {
 		$name = $post["name"];
 		$email = $post["email"];
 		$password = password_hash($post["password"],PASSWORD_DEFAULT);
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		$sql = "UPDATE $this->table SET password = :password WHERE name = :name AND email = :email";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":email",$email, PDO::PARAM_STR);
	 		$stmt->bindValue(":name",$name, PDO::PARAM_STR);
	 		$stmt->bindValue(":password",$password, PDO::PARAM_STR);
	 		$stmt->execute();
	 	}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function find_by_name($name) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "SELECT * FROM $this->table WHERE name = :name";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":name",$name,PDO::PARAM_STR);
 			$stmt->execute();
 			$params = $stmt->fetch(PDO::FETCH_ASSOC);
 			return $params;
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function update_check($post) {
 		$errors = array();
 		$height = $post["height"];
 		$weight = $post["weight"];
 		$age = $post["age"];
 		// height空 数字以外
 		if (empty($height)) {
 			$errors["height_empty"] = "身長を入力してください";
 		}elseif (!is_numeric($height)) {
 			$errors["height_int"] = "半角数字で入力してください";
 		}
 		// weight空　数字以外
 		if (empty($weight)) {
 			$errors["weight_empty"] = "体重を入力してください";
 		}elseif (!is_numeric($weight)) {
 			$errors["weight_int"] = "半角数字で入力してください";
 		}
 		// age空　数字以外
 		if (!is_numeric($age)) {
 			$errors["age_int"] = "半角整数値で入力してください";
 		}elseif(empty($age)) {
 			$errors["age_empty"] = "年齢を入力してください";
 		}
 		return $errors;
 	}
 	public function update_user($post){
 		$height = (float)$post["height"];
 		$weight = (float)$post["weight"];
 		$age = $post["age"];
 		$frequency = $post["frequency"];
 		$gender = $post["gender"];
 		$purpose = $post["purpose"];
 		$id = $post["id"];
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		$sql = "UPDATE $this->table SET height = :height, weight = :weight, age = :age, frequency = :frequency, gender = :gender, purpose = :purpose WHERE id = :id";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":id", $id, PDO::PARAM_INT);
	 		$stmt->execute(array("height"=>$height, "weight"=>$weight, "age"=>$age, "frequency"=>$frequency, "gender"=>$gender, "purpose"=>$purpose, "id"=>$id));
	 	}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function delete_user($id){
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		$sql = "UPDATE $this->table SET role=1 WHERE id = :id";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":id", $id, PDO::PARAM_INT);
	 		$stmt->execute();
	 	}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function find_all() {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "SELECT * FROM $this->table WHERE NOT role = 2";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->execute();
 			$params = $stmt->fetchAll(PDO::FETCH_ASSOC);
 			return $params;
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function return_user($id) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		$sql = "UPDATE $this->table SET role=0 WHERE id = :id";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":id", $id, PDO::PARAM_INT);
	 		$stmt->execute();
	 	}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 }
?>
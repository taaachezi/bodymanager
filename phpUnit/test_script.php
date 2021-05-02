<?php
class User{
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
}
class Intake {
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
}
class Item {
		public function check_form($post){
 		$name = $post["name"];
 		$protein = $post["protein"];
 		$carbo = $post["carbo"];
 		$fat = $post["fat"];
 		$user_id = $post["user_id"];
 		$errors = array();
 		$is_name = "";
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
}
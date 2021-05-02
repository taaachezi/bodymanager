<?php
	require_once(ROOT_PATH."/Models/User.php");
	require_once(ROOT_PATH."/Models/TargetIntake.php");
	require_once(ROOT_PATH."/Models/TotalIntake.php");
	require_once(ROOT_PATH."/Models/Intake.php");
	class UsersController {
		private $User;
		private $request;
		private $TargetIntake;
		private $TotalIntake;
		private $Intake;
		public function __construct() {
			$this->request["get"] = $_GET;
			$this->request["post"] = $_POST;
			$this->User = new User();
			$dbh = $this->User->get_db_handler();
			$this->TargetIntake = new TargetIntake($dbh);
			$this->TotalIntake = new TotalIntake($dbh);
			$this->Intake = new Intake($dbh);
		}
		public function create() {
			$this->User->insert_user($this->request["post"]);
		}
		public function index($current_user,$current_time) {
			// 目標値取得
		 	$target_intake = $this->TargetIntake->calculation_target($current_user);
		 	// 摂取履歴取得
		 	$intakes_all = $this->Intake->find_all($current_user["id"],$current_time);
		 	// totalintakeに情報があるか確認
		 	$total_intake_user = $this->TotalIntake->find_by_user_id($current_user["id"],$current_time);
		 	if (!empty($intakes_all)) {
		 		// 摂取履歴合計計算
		 		$total_intake = $this->TotalIntake->calculation_total_intake($intakes_all);
		 		$this->TotalIntake->delete_total_intake($current_user["id"],$current_time);
		 		$this->TotalIntake->insert_total_intake($total_intake,$current_user["id"],$current_time);
		 		$diff_intake = $this->TargetIntake->calculation_diff_intake($target_intake,$total_intake);
		 		return $diff_intake;

		 	}else{
		 		$this->TotalIntake->delete_total_intake($current_user["id"],$current_time);
		 		$this->TotalIntake->reset_total_intake($current_user["id"],$current_time);
		 		return $target_intake;
		 	}
		}
		public function show() {
			// ヘッダーからの遷移
			if(isset($this->request["get"]["user_name"])){
				$params = $this->User->find_by_name($this->request["get"]["user_name"]);
				return $params;
			} elseif (isset($_SESSION["user_name"])) {
				$params = $this->User->find_by_name($_SESSION["user_name"]);
				return $params;
			} else {
				return $params = null;
			}
		}
		public function update() {
			$this->User->update_user($this->request["post"]);
		}
		public function delete() {
			$this->User->delete_user($this->request["post"]["user_id"]);
		}
		public function return() {
			$this->User->return_user($this->request["post"]["user_id"]);
		}

		public function admin_index() {
			$users = $this->User->find_all();
			return $users;
		}
		public function login() {
			$user = $this->User->user_check($this->request["post"]);
			$errors = $this->User->login_check($this->request["post"],$user);
			return $errors;
		}
		public function validate() {
			if (isset($_POST["registration"])) {
				$errors = $this->User->registration_check($this->request["post"]);
				return $errors;
			}elseif(isset($_POST["update_user"])){
				$errors = $this->User->update_check($this->request["post"]);
				return $errors;
			}
		}
		public function password_reset() {
			$password = $this->request["post"]["password"];
			$password_conf = $this->request["post"]["password_conf"];
			$user = $this->User->user_check($this->request["post"]);
			if ( $user && $password && mb_strlen($password)>=6 && $password == $password_conf) {
				$this->User->update_password($this->request["post"]);
				return $user;
			}else{
				$errors = "入力に誤りがあります";
				return $errors;
			}

		}
	}
?>
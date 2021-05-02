<?php
	require_once(ROOT_PATH."/Models/Intake.php");
	require_once(ROOT_PATH."/Models/TotalIntake.php");
	class IntakesController {
		private $Intake;
		private $request;
		private $TotalIntake;
		public function __construct() {
			$this->request["get"] = $_GET;
			$this->request["post"] = $_POST;
			$this->Intake = new Intake();
			$dbh = $this->Intake->get_db_handler();
			$this->TotalIntake = new TotalIntake($dbh);
		}
		public function create() {
			if (isset($_POST["all"])) {
				unset($this->request["post"]["favorite_item"]);
				$errors = $this->Intake->check_intake($this->request["post"]);
				if (isset($errors)) {
					return $errors;
				}
				$this->Intake->insert_intake($this->request["post"]);
			}elseif (isset($_POST["favorite"])) {
				unset($this->request["post"]["all_item"]);
				$errors = $this->Intake->check_intake($this->request["post"]);
				if (isset($errors)) {
					return $errors;
				}
				$this->Intake->insert_intake($this->request["post"]);
			}
		}
		public function index() {
			$user_id = $this->request["get"]["user_id"] ?? $_SESSION["user_id"];
			$intakes = $this->Intake->find_all($user_id,$_SESSION["current_time"]);
			return $intakes;
		}
		public function show() {
			
		}
		public function update() {
			
		}
		public function delete() {
			$this->Intake->delete_intake($this->request["post"]["id"]);
		}
	}
?>
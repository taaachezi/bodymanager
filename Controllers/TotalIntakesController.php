<?php
	require_once(ROOT_PATH."/Models/TotalIntake.php");
	require_once(ROOT_PATH."/Models/TargetIntake.php");
	class TotalIntakesController {
		private $request;
		private $TotalIntake;
		private $TargetIntake;
		public function __construct() {
			$this->request["get"] = $_GET;
			$this->request["post"] = $_POST;
			$this->TotalIntake = new TotalIntake();
			$dbh = $this->TotalIntake->get_db_handler();
			$this->TargetIntake = new TargetIntake($dbh);
		}
		public function create() {
		}
		public function index() {
			$items = $this->TotalIntake->find_all_group_day($_SESSION["user_id"]);
			return $items;
		}
		public function show() {
			
		}
		public function update() {
			
		}
		public function delete() {
			
		}
	}
?>
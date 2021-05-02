<?php
	require_once(ROOT_PATH."/Models/TargetIntake.php");
	class TargetIntakesController {
		private $TargetIntake;
		private $request;
		public function __construct() {
			$this->request["get"] = $_GET;
			$this->request["post"] = $_POST;
			$this->TargetIntake = new TargetIntake();
		}
		public function create() {
			
		}
		public function index() {
			$target_intake = $this->TargetIntake->calculation_target($_SESSION["non_member_data"]);
			return $target_intake;
		}
		public function show() {
			
		}
		public function update() {
			
		}
		public function delete() {
			
		}
	}
?>
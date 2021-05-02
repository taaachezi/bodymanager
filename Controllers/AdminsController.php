<?php
	require_once(ROOT_PATH."/Models/Admin.php");
	class AdminsController {
		private $Admin;
		private $request;
		private $User;
		public function __construct() {
			$this->request["get"] = $_GET;
			$this->request["post"] = $_POST;
			$this->Admin = new Admin();
			$dbh = $this->User->get_db_handler();
			$this->User = new User($dbh);
		}
		public function create() {
			
		}
		public function index() {

		}
		public function show() {
			
		}
		public function update() {
			
		}
		public function delete() {
			
		}
	}
?>
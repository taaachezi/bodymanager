<?php
	require_once(ROOT_PATH."/Models/Item.php");
	class ItemsController {
		private $Item;
		private $request;
		public function __construct() {
			$this->request["get"] = $_GET;
			$this->request["post"] = $_POST;
			$this->Item = new Item();
		}
		public function create() {
			$params = $this->Item->insert_item($this->request["post"]);
		}
		public function index($user_id) {
			if (isset($this->request["post"]["search"])) {
				$items = $this->Item->find_search($this->request["post"]);
			}else{
				$items = $this->Item->find_all($user_id);
			}
			return $items;
		}
		public function show() {
			
		}
		public function update() {
			$this->Item->update_item($this->request["post"]);
		}
		public function delete() {
			$this->Item->delete_item($this->request["get"]["id"]);
		}
		public function validate(){
			$errors = $this->Item->check_form($this->request["post"]);
			return $errors;
		}
	}
?>
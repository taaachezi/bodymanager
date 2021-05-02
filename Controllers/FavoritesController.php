<!-- item_idとuser_idを受け取る
	where user_id でfavorite登録データを取得
	item_idがあればdelete
	item_idがなければinsert
	foreach内でfunction is_favorite($user_id)を発行し存在確認　true:falseで条件分岐
 -->
<?php
	require_once(ROOT_PATH."/Models/Favorite.php");
	class FavoritesController {
		private $Favorite;
		private $request;
		public function __construct() {
			$this->request["get"] = $_GET;
			$this->request["post"] = $_POST;
			$this->Favorite = new Favorite();
		}
		public function create($user_id) {
			$this->Favorite->insert_favorite($user_id, $this->request["get"]["id"]);
		}
		public function delete($user_id) {
			$this->Favorite->delete_favorite($user_id, $this->request["get"]["id"]);
		}
		public function index($user_id){
			$favorites = $this->Favorite->find_all($user_id);
			return $favorites;
		}
	}
?>
<?php use PHPUnit\Framework\TestCase;
// クラス名とファイル名は同じにしておく必要がある
// 食材登録・更新チェック
require_once(dirname(__FILE__)."/test_script.php");
class ItemTest extends TestCase{
	// assert　テストオプションメソッド
	protected $object;
		protected function setUp():void{
			$this->object = new Item();
		}
    	public function testCheckForm(){
    		$post["name"] = "hoge";
    		$post["protein"] = "10";
    		$post["carbo"] = "10";
    		$post["fat"] = "10";
    		$is_name = "";
    		$errors = [];
    		$this->assertEquals(array(),$this->object->check_form($post));
    	}
}
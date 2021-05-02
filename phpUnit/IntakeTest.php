<?php use PHPUnit\Framework\TestCase;
// クラス名とファイル名は同じにしておく必要がある
// 食材摂取チェック
require_once(dirname(__FILE__)."/test_script.php");
class IntakeTest extends TestCase{
	// assert　テストオプションメソッド
	protected $object;
		protected function setUp():void{
			$this->object = new Intake();
		}
    	public function testCheckForm(){
    		$post["quantity"] = "100";
            $post["all_item"] = null;
            $post["favorite_item"] = "1";
    		$this->assertEquals(null,$this->object->check_intake($post));
    	}
}
<?php
// require_once(dirname(__FILE__)."/../Models/User.php");
require_once(dirname(__FILE__)."/test_script.php");
use PHPUnit\Framework\TestCase;
// クラス名とファイル名は同じにしておく必要がある
class UserTest extends TestCase{
	// assert　テストオプションメソッド
	protected $object;
		protected function setUp():void{
			$this->object = new User();
		}
    	public function testLoginCheck(){
    		$post["email"] = "guest@guest";
 			$post["name"] = "guest";
 			$post["password"] = "guestlogin";
 			$user["password"] = "$2y$10$3sYfIUK6BHHqCbJ/GRJ26umcF1FIvLoALW8TubMlyjhB3Ikz6zgj2";
    		$this->assertEquals(array(),$this->object->login_check($post,$user));
    	}
    	public function testUpdateCheck(){
    		$post["height"] = "170";
    		$post["weight"] = "70";
    		$post["age"] = "25";
    		$this->assertEquals(array(),$this->object->update_check($post));
    	}
}
?>
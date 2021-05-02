<?php
 require_once(ROOT_PATH."/Models/Db.php");
 // Use classもextendsしたい
 class Admin extends Db {
 	private $table = "admins";
 	public function __construct($dbh = null){
 		parent::__construct($dbh);
 	}
 }
?>
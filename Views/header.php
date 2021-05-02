
<div class="container">
	<div class="row mt-3 justify-content-between">
		<div class="logo col-2">
			<?php if (isset($_SESSION["user_name"])&&$_SESSION["user_name"]!="admin") :?>
				<a href="/users/index.php" title=""><img class="logo" src="/img/logo1.png" alt="" style="width: 14vh; opacity: 0.6;"></a>
			<?php else: ?>
				<a href="/index.php" title=""><img class="logo"  src="/img/logo1.png" alt="" style="width: 14vh; opacity: 0.6;"></a>
			<?php endif ?>
		</div>
		<div class="admin_link col-4 text-end dropdown pt-3">
			<a class="btn btn-outline-secondary rounded-pill dropdown-toggle shadow-lg" href="#" title="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">Menu</a>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				<?php if (isset($_SESSION["user_name"]) && $_SESSION["user_name"]=="admin"): ?>
					<li><a class="dropdown-item" href="/index.php" title="">ログアウト</a></li>
				<?php elseif(!isset($_SESSION["user_name"])): ?>
				<li><a class="dropdown-item" href="/admins/login.php" title="">管理者ログイン</a></li>
				<li><a class="dropdown-item" href="/users/login.php" title="">ログイン</a></li>
				<li><a class="dropdown-item" href="/users/registration.php" title="">新規登録</a></li>
				<?php else: ?>
				<li><a class="dropdown-item" href="/users/index.php" title="">トップページ</a></li>
				<li><a class="dropdown-item" href="/users/show.php?user_name=<?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];} ?>" title="">ユーザ情報</a></li>
				<li><a class="dropdown-item" href="/index.php" title="">ログアウト</a></li>
				<?php endif ?>
			</ul>
		</div>
	</div>
</div>
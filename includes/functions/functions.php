<?php

// function print title if exist , if not exist print Default
function printTitle(){
	global $pageTitle;
	
	if (isset($pageTitle)) {
		echo $pageTitle;
	} else {
		echo "Default";
	}
}

// redirct function
// v1.0
/*function redirectToHome($errMsg, $time = 3){
	echo '<div class="container">';
		echo '<div class="alert alert-error"><i class="fa fa-close"></i> '. $errMsg .'</div>';
		echo '<p> you will be redirect to home page after '. $time .' seconds</p>';
	echo '</div>';
	header("refresh:". $time ."; url = index.php");
	exit();
}

// redirect function v2.0
function redirectTo($Msg, $url = null, $time = 3){
	if($url === null){ 
		$url = 'index.php';
		$link = 'admin area';
	} elseif($url == 'back') {
		if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'previous page';
		} else {
			$url = 'index.php';
			$link = 'admin area';
		}
	}
	echo $Msg;
	echo '<p> you will be redirect to '. $link .' after '. $time .' seconds</p>';
	header("refresh: $time;url = $url");
	exit();
}
*/
// redirect function v3.0
function redirectTo($Msg = '', $url = 'index.php', $time = 3){
	global $pageTitle;
	$link = 'Main ' . $pageTitle . ' page';
	if($url === null){ 
		$url = 'index.php';
		$link = 'admin area';
	} elseif($url == 'back') {
		if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'previous page';
		}
	}
	echo $Msg;
	if ($time === false){
		echo "<a class='btn btn-sky' href='$url'><i class='fa fa-arrow-left'></i> back</a>";
	} else {
		echo '<p> you will be redirect to '. $link .' after '. $time .' seconds</p>';
		header("refresh: $time;url = $url");
		exit();
	}
}

// check item if exist in database
function checkItemExist($select, $tableName, $value){
	global $connect;
	$stmnt = $connect->prepare("SELECT $select FROM $tableName WHERE $select = ?");
	$stmnt->execute(array($value));
	return $stmnt->rowCount();
}

/*
// function calculate items v1.0
function calcItems($item, $tableName){
	global $connect;
	$stmnt2 = $connect->prepare("SELECT COUNT($item) FROM $tableName");
	$stmnt2->execute();
	return $stmnt2->fetchColumn();
}*/

// function calculate items v2.0
/* !!! In maintenance !!!
function calcItems($select, $tableName, $col = '', $value = ''){
	global $connect;
	if ($col === '') {
		$w = '';
	} else {
		$w = "WHERE $col = ?";
	}
	$stmt = $connect->prepare("SELECT $select FROM $tableName $w");
	$stmt->execute(array($value));
	return $stmt->fetchAll();
//	count(getAll($select, $tableName, $col, $value));
}*/

// function ordering the items v1.0
function getItems($select, $tableName, $order, $limit = 3) {
	global $connect;
	$stmnt3 = $connect->prepare("SELECT $select FROM $tableName ORDER BY $order DESC LIMIT $limit");
	$stmnt3->execute();
	return $stmnt3->fetchAll();
}

// function add class active on active link v1.0
function addClassActive($name){
	global $pageTitle;
	if (isset($pageTitle) && strtolower($pageTitle) == strtolower($name)) {
		echo 'class="active"';
	}
}

// get all categories
function getCats(){
	global $connect;
	$getCat = $connect->prepare("SELECT * FROM category ORDER BY id DESC");
	$getCat->execute();
	return $getCat->fetchAll();
}

// get all items
function showItems($catId){
	global $connect;
	$getItem = $connect->prepare("SELECT * FROM items WHERE catId = ? ORDER BY id DESC");
	$getItem->execute(array($catId));
	return $getItem->fetchAll();
}

// check the member status
function userStatus($user){
	global $connect;
	$userStat = $connect->prepare("SELECT * 
																	FROM users 
																	WHERE username = ? 
																	AND regStatus = 0");
  $userStat->execute(array($user));
  return $userStat->rowCount();
}

// check items exist
function getMemeberInfo($member = null){
	global $connect;
	$stmnt4 = $connect->prepare("SELECT * FROM users WHERE username = ?");
	$stmnt4->execute(array($member));
	if ($stmnt4->rowCount() > 0 && $member !== null) {
		$stmnt4 = $connect->prepare("SELECT * FROM users WHERE username = ?");
		$stmnt4->execute(array($member));
		return $stmnt4->fetchAll();
	} else {
		header("location: index.php");
	}
}

// get all items
function getIts($where, $value, $limit){
	global $connect;
	$getItem = $connect->prepare("SELECT * FROM items WHERE $where = ? ORDER BY id DESC LIMIT $limit");
	$getItem->execute(array($value));
	return $getItem->fetchAll();
}

// get all function for get all record any page
function getAll($select, $table, $where = '', $value = '', $and = null, $order = 'id', $by = 'DESC'){
	global $connect;
	$w = $where != '' ? 'WHERE '. $where .' = ?' : '';
	$a = $and != null ? ' AND '. $and : '';
	$o = $order != null ? $order : 'id';

	$getAll = $connect->prepare("SELECT $select FROM $table $w ORDER BY $o $by");
	$getAll->execute(array($value));
	return $getAll->fetchAll();
}

// function calc file max size on byte
function fileMaxSize($maxSize = 1){
	return $maxSize * 1024 * 1024;
}

// calc views count on every ads
function calcViews(){
	global $connect;
	$calcViews = $connect->prepare("UPDATE items SET views = views+1 WHERE id = ?");
	$calcViews->execute(array($_GET['id']));
	$views = $connect->prepare("SELECT views FROM items WHERE id = ?");
	$views->execute(array($_GET['id']));
	foreach($views->fetchAll() as $r){
		return $r['views'];
	}
}

// hashed password fuction
function hashed_pass($password){
	return sha1($password);
}
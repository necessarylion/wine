<?php


if(isset($_COOKIE['admin'])){
	$link = $link_url.'extension/calendar/';
	header("location:$link");
}
?>
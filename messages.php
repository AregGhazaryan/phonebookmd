<?php
function setMsg($text, $type){
		if ($type == 'error') {
			$_SESSION['errorMsg'] = $text;
		} else {
			$_SESSION['successMsg'] = $text;
		}
	}

function display(){
		if (isset($_SESSION['errorMsg'])) {
			echo '<div class="alert alert-danger">'.$_SESSION['errorMsg'].'</div>';
			unset($_SESSION['errorMsg']);
		}
		if (isset($_SESSION['successMsg'])) {
			echo '<div class="alert alert-success">'.$_SESSION['successMsg'].'</div>';
			unset($_SESSION['successMsg']);
		}
	}

function displayFloat(){
	if (isset($_SESSION['errorMsg'])) {
		echo '<div class="alert alert-danger fl-msg w-100">'.$_SESSION['errorMsg'].'</div>';
		unset($_SESSION['errorMsg']);
	}
	if (isset($_SESSION['successMsg'])) {
		echo '<div class="alert alert-success fl-msg w-100">'.$_SESSION['successMsg'].'</div>';
		unset($_SESSION['successMsg']);
	}
}

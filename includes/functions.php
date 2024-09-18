<?php
function hashPassword($password) {
	return password_hash($password, PASSWORD_BCRYPT);
}
?>

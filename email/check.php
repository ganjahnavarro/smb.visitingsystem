<!DOCTYPE html>
<html>
<head>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
</head>
<body>

	<?php
		require_once 'System.php';
		if (class_exists ( 'System' )) {
			echo '<p>got Pear</p>';
		} else {
			echo '<p>no Pear</p>';
		}
		;
		
		$GLOBALS ['resetcodes'] = array (
				"foo" => "bar",
				"bar" => "foo"
		);
	?>
</body>
</html>

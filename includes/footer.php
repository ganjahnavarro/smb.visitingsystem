<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/logoutmodal.php' ); ?>

<script>
	var $rows = $('.searchableTable tbody tr');
	$('#searchInput').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});

	$(document).ready(function() { 
		$(".sortableTable").tablesorter(); 
	});

	localStorage.setItem("retryCount", 0);
</script>
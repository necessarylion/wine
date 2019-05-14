<script>
$(document).ready(function(){

	$('.sidebar-detail').prepend('<li class="nav-item">'+
		'<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">'+
			'<i class="fas fa-fw fa-cog"></i>'+
			'<span>WINE DETAIL</span>'+
		'</a>'+
		'<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">'+
			'<div class="bg-white py-2 collapse-inner rounded">'+
			'<a href="import.php" class="collapse-item" href="buttons.html">Import Data</a>'+
			'</div>'+
		'</div>'+
		'</li>')
})
</script>
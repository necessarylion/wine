<?php include "component/header.php";?>
<div class="container-fluid">
<div class="card">
	<div class="card-header title">

	</div>
	<div class="card-body output">
	
	</div>
</div>


</div>
<?php include "component/footer.php";
	  include "index_script.php";
?>

<script>
$(document).ready(function(){
	
	jsonAjax({get: "<?php echo $_GET['id'] ?>"}, 'run/cal/note.php', function(o){
		$.each(o, function(k,v){
			$('.output').prepend(v.body)
			$('.title').prepend(v.title)
		})
		Prism.highlightAll();
		
	})
})
</script>

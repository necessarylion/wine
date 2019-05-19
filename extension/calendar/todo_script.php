<script>
$(document).ready(function(){
	$('#todo').addClass('active');
function load(){
	jsonAjax({load: 1}, "run/cal/todo.php", function(output){
		$.each(output, function(k,v){
			$('.output').prepend('<div class="card shadow mb-2 border-left-primary">'+
									'<div class="card-body py-3" tanboe='+v.id+' sar='+v.title+'>'+
										'<span class="m-0 font-weight-bold text-primary sar">'+v.title+'</span>'+

										'<a href="#" class="btn btn-danger btn-circle btn-sm float-right delete">'+
											'<i class="fas fa-trash"></i>'+
										'</a>'+
										'<a href="#" class="btn btn-success btn-circle btn-sm float-right mr-2 edit">'+
											'<i class="fas fa-edit"></i>'+
										'</a>'+
									'</div>'+
								'</div>')
		})
	})
}
load();
$(document).on('click','.delete', function(){
	var id = $(this).parent().attr('tanboe');
	ele = $(this).parent().parent();
	bootbox.confirm("Are You Sure?", function(result){
		if(result == true){
			Ajax({del: id}, "run/cal/todo.php", function(o){
				if(o == 'success'){
					ele.remove().hide();
				}
			})
		}
	})

})
$(document).on('click','.edit', function(){
	var id = $(this).parent().attr('tanboe');
	var sar = $(this).parent().attr('sar');
	var sib = $(this).siblings('.sar');
	bootbox.prompt({
		title: "Edit",
		palceholder: "Title",
		value: sar,
		callback: function(result){
			if(result != null){
				if(result != ''){
					Ajax({edit: id, title: result}, "run/cal/todo.php", function(o){
						if(o == "success"){
							sib.html(result);
						}
					})
				}
			}
		}
	})
	
})

$(document).on('click','.new', function(){
	bootbox.prompt({
		title: "New",
		palceholder: "Title",
		callback: function(result){
			if(result != null){
				if(result != ''){
					jsonAjax({new: 1, title: result}, "run/cal/todo.php", function(o){
						
						if(o.message == "success"){
							$('.output').prepend('<div class="card shadow mb-2 border-left-success">'+
									'<div class="card-body py-3" tanboe='+o.id+' sar='+result+'>'+
										'<span class="m-0 font-weight-bold text-primary sar">'+result+'</span>'+

										'<a href="#" class="btn btn-danger btn-circle btn-sm float-right delete">'+
											'<i class="fas fa-trash"></i>'+
										'</a>'+
										'<a href="#" class="btn btn-success btn-circle btn-sm float-right mr-2 edit">'+
											'<i class="fas fa-edit"></i>'+
										'</a>'+
									'</div>'+
								'</div>')
						}
					})
				}
			}
		}
	})
	
})
})
</script>
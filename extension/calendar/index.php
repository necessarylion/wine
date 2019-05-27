<?php include "component/header.php";?>
<div class="container-fluid">
<style>
body{
	color: black !important;
}
#content{
	background: white !important;
}
ul li{
  display: inline;
}
#color-chooser{
	margin-top: 20px;
	padding: 0px 10px 10px 20px !important;
}
#color-chooser li .fa{
    font-size: 35px !important;
}
@media (min-width: 768px) {
     .fc-today .fc-day-number{
	font-size: 30px !important;
	position: absolute;
	padding: 20px 20px 20px 45px;
	z-index: 400;
}
}
.pull-right{
	float: right;
}
.pointer{
	cursor:pointer;
	font-size: 25px;
}
</style>
<div class="row">
	<div class="col-md-9">
		<div id="calendar"></div>
	</div>
	<div class="col-md-3">
		<div class="card p-0">
			<div class="card-header bg-primary text-white text-bold">
				Easy Event
			</div>
			<div class="card-body p-0">
				 <ul class="fc-color-picker" id="color-chooser">
                    <li><a class="text-primary" href="#"><i class="fa fa-square"></i></a></li>
                    <li><a class="text-warning" href="#"><i class="fa fa-square"></i></a></li>
                    <li><a class="text-success" href="#"><i class="fa fa-square"></i></a></li>
                    <li><a class="text-danger" href="#"><i class="fa fa-square"></i></a></li>
                    <li><a style="color:black" href="#"><i class="fa fa-square"></i></a></li>
                    <li><a style="color:blue" href="#"><i class="fa fa-square"></i></a></li>
                    <li><a style="color:red" href="#"><i class="fa fa-square"></i></a></li>
                  </ul>
			</div>
			<div class="card-footer">
				
			<div class="input-group">
				
				<input type="text" class="form-control" required="" id='add-easy'>
				<div class="input-group-append">
				<span class="input-group-text text-bold save"><i class="fas fa-save"></i></span>
				</div>

			</div>
				
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header bg-primary text-white text-bold">
				Easy Event List
			</div>
			<div class="card-body">
						<div id="external-events">
                  
          
            </div>
						<hr>
						<div class="checkbox">
							<label for="drop-remove">
								<input type="checkbox" id="drop-remove">
								remove after drop
							</label>
						</div>
			</div>
		</div>
	</div>
</div>

</div>

<?php include "component/footer.php";
	  include "index_script.php";
?>
<script>
 $(document).on("keypress", "#add-easy", function(e){
        if(e.which == 13){
            $('.save').click();
        }
	});
	
</script>
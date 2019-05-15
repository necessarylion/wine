<?php include "component/header.php";?>
<div class="container-fluid">


<div class="card">
	<div class="card-header">
		<div class="pull-left">
			<h3 class="panel-title"> REPORT</h3>
		</div>
		<div class="clearfix"></div>
	</div><!-- /.panel-heading -->
	<div class="card-body">

		<div class="row">
			<div class="col-md-6">
			<div class="alert alert-danger text-bold" role="alert">
				  <h5 class="alert-heading text-bold">IMPORTANT:</h5>
				  <p></p>
				  <p class="mb-0">
				  File Must BE Excel; and follow sample format
				  </p>
			</div>


			
				<div class="form-group">
					<div class="err pull-right"></div>
					<div class="input-group mb-15">
						<input class="form-control no-border-right file-name" disabled type="text">
						<span class="input-group-addon bg-primary select-file pointer">SELECT FILE</span>
					</div>
					<input type="file" name="excel" id="fileUpload" style='display:none'>
					
				</div>
			</div>
			<div class="col-md-6">
				<a href="sample.xlsx" class="badge badge-success pull-right"><i class="fa fa-files-o" aria-hidden="true"></i>Download Sample File</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<button class="btn btn-success" onclick="Upload()">UPLOAD</button>
			</div>
		</div>
		
	</div>
	</div><!-- /.panel-body -->
	<div class="panel-footer">
		<br>

</div>

</div>
<?php include "component/footer.php";
	  include "import_script.php";
?>

<?php include "component/header.php";?>
<style>
.new{
	position:fixed;
	bottom: 20px;
	right: 20px
}
.tools{
	position: absolute;
    bottom: 15px;
    right: 15px;
}
.more{
	padding-top : 20px;
	position: absolute;
    bottom: 20px;
}
.title-div{
	margin-bottom: 50px;
	
}
pre{
	overflow:hidden;
}

</style>


<div class="container-fluid" id='app-1' style='display:none'>
<div class="row">
	<div class="col-md-5">
		<div class="form-group">
			<input type="text" @keyup='searchFilter("search")' id='search' class="form-control" placeholder="Search" >
			
		</div>
	</div>

	<div class="col-md-7">
				
		Filter by Date  :  <input type="text"  class="date-d from_date text-center" value='<?php echo date('01/01/Y'); ?>'> &nbsp;
		<input type="text"  class="date-d to_date text-center" value='<?php echo date('d/m/Y'); ?>'>
				
	</div>	
</div>
<div class="row" >

	<div class="col-md-4 mb-4 notes" v-for="(note, index) in notes">
		<div class="card border-left-primary shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center title-div">
			<div class="col mr-2 p-0">
				<div class="text-center font-weight-bold text-primary text-uppercase mb-1 title">{{note.title }}</div>
				<hr>
				<div class="text-center text-gray mb-1 body " v-html="cutString(note.body)"></div>
				
			</div>
			</div>
			<div class="text-center mt-4 more">
				<a v-bind:href='link+note.id' class="text-bold btn btn-sm btn-primary rounded">More <i class="fas fa-chevron-circle-down"></i></a>
			</div>
			<div class="text-right tools">
				<a href="#" class="btn btn-success btn-circle btn-sm edit" @click="edit_note(index, note.id)">
					<i class="fas fa-edit"></i>
				</a>
				<a href="#" class="btn btn-danger btn-circle btn-sm delete" @click="delete_note(index, note.id)">
					<i class="fas fa-trash"></i>
				</a>
			</div>
		</div>
		</div>
	</div>



</div>

<span class="load-more btn btn-sm btn-danger pointer loadmore" @click="loadMore"  v-if="notes.length > 19">Load More</span>
<br><br>
<a href="#" class="btn btn-primary btn-circle btn-lg new" @click="new_note">
	<i class="fas fa-plus-circle"></i>
</a>



</div>





<?php include "component/footer.php";
	  include "note_script.php";
?>

<!-- Modal -->
<div class="modal fade" id="modelId" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			
			<div class="modal-body">
						<input type="hidden" id='note_id' value=''>
						<input type="hidden" id='note_key' value=''>
						<div class="form-group">
							<label for="">Title</label>
							<input type="text" class="form-control note-title" name="note-title" id="note-title"  placeholder="Title">
						</div>
						<div class="form-group">
							<label for="">Body</label>
							<textarea class="form-control" name="note-body" id="note-body" rows="10"></textarea>
						</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary save">Save</button>
			</div>
			
		</div>
	</div>
</div>

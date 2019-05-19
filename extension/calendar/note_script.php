<script>
$(document).ready(function(){
	$('#note').addClass('active');
	$('#app-1').show();
	var editor = CKEDITOR.replace( 'note-body' );

	$('.date-d').datepicker({
    
    todayHighlight: true,
    autoclose: true, orientation: "right",
		dateFormat: 'dd/mm/yy',
	});

	$('.date-d').on('change',function(){
			from = moment($('.from_date').datepicker('getDate')).format('YYYY-MM-DD');
			to = moment($('.to_date').datepicker('getDate')).format('YYYY-MM-DD');
			app.from_date = from;
			app.to_date = to;
			app.filterDate();
	})
})

$(document).on('click','.save',function(){

							var note_id = $('#note_id').val();
							var note_key = $('#note_key').val();
							var title = $('#note-title').val();
							var body = CKEDITOR.instances["note-body"].getData();
					

						if(title != ''){
						
							Ajax({body: body, title: title, note_id: note_id},"run/cal/note.php", function(o){
								daa = JSON.parse(o);
								if(daa.type == 'new'){
											data = daa.result;
											app.notes.unshift({id: data.id, title: data.title, body: data.body, date_time : data.date_time  });
										
								  
								}
								else{

									app.notes[note_key].title = title;
									app.notes[note_key].body = body;
								}
								console.log(daa)
							})
							$('#modelId').modal('hide');
							$('#note-title').val('');
							$('#note-id').val('');
							CKEDITOR.instances["note-body"].setData('');
						}
						else{
							fail_alert("PLEASE WRITE TITLE");
							
						}
				
})

function fail_alert(text){
	bootbox.alert({
		size: "small",
		message: text,
		title: "ERROR" 
	}).find('.modal-content').css({ 'font-weight' : 'bold','text-align':'center',top: '70px', color: '#F00','border-top': '4px solid red' , 'font-weight' : 'bold'} );

}

var app = new Vue({
  el: '#app-1',
  data: {
		search: '',
		notes: [],
		link: "detail.php?id=",
		from_date : '',
		to_date: '',
		limit: 20
	
  },
  mounted: function(){
	    var self = this;
		jsonAjax({load: 1}, "run/cal/note.php", function(output){
			console.log(output);
			$.each(output, function(k,v){
				self.notes.push({id: v.id, title: v.title, body: v.body, date_time : v.date_time  });
			})
			
		})
		
  },
  methods: {
	  new_note: function(){
			console.log('new');
	  		var self = this;
						$('#note-title').val('');
						$('#note-id').val('');
						CKEDITOR.instances["note-body"].setData('');
						$('#modelId').modal('show');

	  },
	  delete_note: function(index, id){
		  var self = this;
		   bootbox.confirm("Are You Sure?", function(result){
			   if(result == true){
					
					self.notes.splice(index, 1)
					Ajax({del_id : id}, "run/cal/note.php", function(o){

					})
			   }
		   })
		},
		edit_note: function(key, id) {
			   var self = this;
				 
				 var a = this.notes[key].title;
				 var b = this.notes[key].body;
				 $('#modelId').modal('show');
				 $('#note-title').val(a);
				 $('#note_id').val(id);
				 $('#note_key').val(key);
				CKEDITOR.instances["note-body"].setData(b);


				
				
      }
		,
		filterDate: function(){
			var self = this;
			this.notes = [];
			jsonAjax({from: self.from_date, to: self.to_date}, "run/cal/note.php", function(output){
				$.each(output, function(k,v){
					self.notes.push({id: v.id, title: v.title, body: v.body, date_time : v.date_time  });
				})
			})
		},
		searchFilter: function(){
			var key = $('#search').val();
			this.notes = [];
			var self = this;
			jsonAjax({key : key}, "run/cal/note.php", function(output){
				$.each(output, function(k,v){
					self.notes.push({id: v.id, title: v.title, body: v.body, date_time : v.date_time  });
				})
			})
		},
		loadMore: function(){
			var self = this;
			console.log(self.limit)
			jsonAjax({limit : self.limit}, "run/cal/note.php", function(output){
				$.each(output, function(k,v){
					self.notes.push({id: v.id, title: v.title, body: v.body, date_time : v.date_time  });
				})
				self.limit = self.limit + 20;
				if(output.length < 20 || output == null){
					$('.loadmore').html('NO MORE ROW')
				}
				
			})
		},
		cutString: function(a){
			return	(a.length > 100)? a.slice(0,100)+'...': a;
		 
		}
	}
})



</script>
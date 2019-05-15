<script>
var json_request = {};
json_request["company_id"] = 535;
var json= JSON.stringify(json_request);

function Upload() {
        
   data = $(".file-name").val();

   if(data == ''){
    $.alert("Please Select File First");
   }
   else{
               //Reference the FileUpload element.
               var fileUpload = document.getElementById("fileUpload");
            
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    $.dialog('Loading Please Wait<br><br><div class="progress progress-striped active">'+
                                '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">'+
                                '<span class="sr-only">Loading Please Wait:</span>'+
                                '</div>'+
                                '</div>')
                                $('.jconfirm-closeIcon').hide();
                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function (e) {
                            ProcessExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileUpload.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function (e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
                            
                            ProcessExcel(data);
                        };
                        reader.readAsArrayBuffer(fileUpload.files[0]);
                    }
                } else {
                    $('.err').html
                    $('#excel').val('');
                    $(".file-name").val('');
                    $.alert("This browser does not support HTML5.");
                }

    }
};
    function ProcessExcel(data) {
        
        //Read the Excel File data.
        var workbook = XLSX.read(data, {
            type: 'binary'
        });
 
        //Fetch the name of First Sheet.
        var firstSheet = workbook.SheetNames[0];
 
        //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet],{defval:""});
 

		//console.log(excelRows)
		var myJSON = JSON.stringify(excelRows);
        
      jsonAjax({json: myJSON}, 'action/upload.php', function (output){
		console.log(output);
		$('.err').html
          $('#excel').val('');
          $(".file-name").val('');
          if(output.message == 'success'){
          
            $('.jconfirm-closeIcon').click();
            $.alert('Success');
          }
          else{
            $('.jconfirm-closeIcon').click();
            $.alert("Fail Press F12 for error log");
            console.log(output);
          }
      })
    };
$(document).ready(function(){
    $('#import').addClass('active');
   
    $('.select-file').click(function(){
      $('#fileUpload').click();
    })
    $("#fileUpload").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      var extension = $(this).val().split(".").pop().toLowerCase();
      $(".file-name").val(fileName);
      if(fileName != '' ){
                  if($.inArray(extension, ['xlsx','xls','xlsm','ods']) == -1){ 
                                        $.alert("<b class='text-danger'>Invalid File</b>");
                                        $('#excel').val('');
                                        $(".file-name").val('');
                  }
      }
    });

})
</script>
function $$($data){
    var firstchar = $data.charAt(0);
    if(firstchar == '%'){
      var data = $data.slice(1);
      var ol = $("textarea[name="+data+"]");
      return ol;
    }
    else{
    var ol = $("input[name="+$data+"]");
    return ol;}
  }

  var result = [];
  //check empty function
  $.fn.checkempty = function(text) {
      var value = this.val();
      if(text === undefined){
        var msg = 'Required!';
      }
      else{
        var msg = text;
      }
      var str = this.attr('name');
      var write = str.replace('_',' ');
      if(value==''){
        this.siblings(".form-error").html("<span class='badge badge-danger text-capitalize'>"+msg+"<span>");
        result.push('false')
      }  
       return this; 
  }


  //check email function
  $.fn.checkemail = function() {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      var value = this.val();
      var str = this.attr('name');
      var write = str.replace('_',' ');
      if(value==''){
        this.siblings(".form-error").html("<span class='badge badge-danger text-capitalize'>Email Required!<span>");
       result.push('false')
      }  
      else if(!value.match(emailReg)){
        this.siblings(".form-error").html("<span class='badge badge-danger text-capitalize'>Invalid Email<span>");
       result.push('false')
      } 
      return this;      
  } 

  //check only number function
  $.fn.checknumber = function() {
      var numReg = /^[0-9]+(\.[0-9]+)?$/; 
      var value = this.val();
      var str = this.attr('name');
      var write = str.replace('_',' ');
      if(value==''){
        this.siblings(".form-error").html("<span class='badge badge-danger text-capitalize'>Required!<span>");
       result.push('false')
      }  
      else if(!value.match(numReg)){
        this.siblings(".form-error").html("<span class='badge badge-danger text-capitalize'>Numbers Only<span>");
        result.push('false')
      } 
      return this;      
  } 

  //check only number and set to zero if ture function 
  $.fn.numberonly = function() {
    var numReg = /^[0-9]+(\.[0-9]+)?$/; 
    var value = this.val();
    var str = this.attr('name');
    var write = str.replace('_',' ');
    if(value==''){
      this.val('0');
    }
    else if(!value.match(numReg)){
        this.siblings(".form-error").html("<span class='badge badge-danger text-capitalize'>Only Numbers<span>");
        result.push('false')
       
    } 
      
    return this;      
  } 

  //check phone number
  $.fn.checkphone = function() {
    var numReg = /^[+-]?\d+$/ ;
    var value = this.val();
    var str = this.attr('name');
      var write = str.replace('_',' ');
    if(value==''){
      this.siblings(".form-error").html("<span class='badge badge-danger text-capitalize'>Required!<span>");
     result.push('false')
    }  
    else if(!value.match(numReg)){
      this.siblings(".form-error").html("<span class='badge badge-danger text-capitalize'>Invalid Phone Numbers<span>");
      result.push('false')
    } 
    return this;      
 } 
 

/*
$('#new-post-submit').on('submit',function(event){
  event.preventDefault();
  $('.form-error').html(''); //set error to empty
  var data = new FormData(this); //get form data
  $$('title').checkempty() //check empth with name
  $$('category').checkempty()
  _('body').checkempty()  //used for textarea
  if(result.length != 0){ //set error to empty
      result = [];
  }
  else{ //check no error
       ajax(data,'action.php',function(output){  //ajax function ajax(data, url , output)
          //other additional will be here//
       });
       
  }

})*/
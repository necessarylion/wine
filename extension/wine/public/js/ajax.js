//simple ajax
function Ajax($data,url,handle){
    $.ajax({
        url: url,
        method: "POST",
        data: $data,
        success: function(data){
           return handle(data);
        }
    })
}

//ajax with json result
function jsonAjax($data,url,handle){
    $.ajax({
        url: url,
        method: "POST",
        dataType: "json",
        data: $data,
        success: function(data){
           return handle(data);
        }
    })
}

//ajax for form with json result
function formJsonAjax($data,url,handle){
    $.ajax({
        url: url,
        method: "POST",
        data: $data,
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        success: function(data){
           return handle(data);
           
        }
    })
  }

//ajax for form
 function formAjax($data,url,handle){
    $.ajax({
        url: url,
        method: "POST",
        data: $data,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data){
           return handle(data);
           
        }
    })
  }
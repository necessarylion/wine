<script>

var json_request = {};
var json= JSON.stringify(json_request);

$(document).ready(function(){
  $('#report').addClass('active');

function balance(){
  jsonAjax({load: 1, json: json }, 'action/dashboard.php', function(o){
  
  if(o.c != '0'){
    rfs =( Number(o.d) +  Number(o.c) +  Number(o.r) +  Number(o.e) ) -  Number(o.t)   
    tr =( Number(o.d) +  Number(o.c) +  Number(o.r) +  Number(o.tr_earn) ) -  Number(o.t)    
    
    $('.tr-earn').html(commaSeparate(o.tr_earn));

  }
  else{
    rfs =( Number(o.d) +  Number(o.c) +  Number(o.r) +  Number(o.e) ) -  Number(o.t)   
    tr =( Number(o.d) +  Number(o.c) +  Number(o.r) +  Number(o.e) ) -  Number(o.t)   
    
    $('.tr-earn').html(commaSeparate(o.e));

  }
    $('.rfs-balance').html(commaSeparate(rfs));
    $('.tr-balance').html(commaSeparate(tr));
    $('.deposit').html(commaSeparate(o.d));
    $('.charge').html(commaSeparate(o.c));
    $('.refund').html(commaSeparate(o.r));
    $('.earn').html(commaSeparate(o.e));
    $('.taste').html(commaSeparate(o.t));
  
  
  })
}
balance();

    function load_all($limit , type , handle){
        jsonAjax({detail:1, json:json, limit: $limit, type: type},'action/dashboard.php', function(o){
            $.each(o, function(k, v){
              if(v.t_charge == '0' ){
                tr_earn = v.t_earn
              }
              else{
                tr_earn = v.tr_earn
              }
                    $('#detail_output').append("<tr class='show-re pointer' card='"+v.card+"'>"+
                                "<td>"+moment(v.date_time).format('MM/DD/YYYY H:mm:ss')+"</td>"+
                                "<td>"+v.card+"</td>"+
                                "<td>"+v.owner+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_taste)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_charge)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_deposit)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_refund)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_earn)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(tr_earn)+"</td>"+
                            "</tr>")
            })

            if(handle){
              return handle('success');
            }
            
        })
        
    }

    function filter($limit , search, filter, handle){
        jsonAjax({detail:1, json:json, limit: $limit, search: search, filter: filter},'action/dashboard.php', function(o){
           $('#detail_output').html('');
           
            $.each(o, function(k, v){
              if(v.t_charge == '0' ){
                tr_earn = v.t_earn
              }
              else{
                tr_earn = v.tr_earn
              }
                    $('#detail_output').append("<tr class='show-re pointer' card='"+v.card+"'>"+
                                "<td>"+moment(v.date_time).format('MM/DD/YYYY H:mm:ss')+"</td>"+
                                "<td>"+v.card+"</td>"+
                                "<td>"+v.owner+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_taste)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_charge)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_deposit)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_refund)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_earn)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(tr_earn)+"</td>"+
                            "</tr>")
            })
            return handle(o.length);
        })

    }


    $limit = 50;
    $change = 'no';
    load_all(0, 'customer');
    $(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() > $(document).height()-1 ) {
	
			if($change != 'yes'){
        load_all($limit,1);
			  $limit = $limit+ 50;
      }
			//console.log($limit)
		}
    });
    
    $('#type').change(function(){
        $('#detail_output').html('');
        type = $(this).val();
        load_all(0, type , function(out){
          if(out == 'success'){
            $limit = 50;
            balance();
            $change = 'no';
          } 
        });
        
    })
    $('#type').focus();


    $('.card_owner').select2({
        placeholder: "Card Owner",
        maximumInputLength: 255,
        allowClear: true,
        ajax: {
          url: 'action/search.php',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            var query = {
                search: params.term,
                page: 10
            }

            // Query parameters will be ?search=[term]&page=[page]
            return query;
          },
          processResults: function (data) {
            return {
              results: data
              
            };
          },
          cache: true,
        }
      }).on("select2:unselecting", function(e) {
          $(this).data('state', 'unselected');
      }).on("select2:open", function(e) {
          if ($(this).data('state') === 'unselected') {
              $(this).removeData('state'); 

              var self = $(this);
              setTimeout(function() {
                  self.select2('close');
              }, 1);
          }    
      });

      $('.card_id').select2({
        placeholder: "Card ID",
        maximumInputLength: 255,
        allowClear: true,
        ajax: {
          url: 'action/search.php',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            var query = {
                card: params.term,
                page: 10
            }

            // Query parameters will be ?search=[term]&page=[page]
            return query;
          },
          processResults: function (data) {
            return {
              results: data
              
            };
          },
          cache: true,
        }
      }).on("select2:unselecting", function(e) {
          $(this).data('state', 'unselected');
      }).on("select2:open", function(e) {
          if ($(this).data('state') === 'unselected') {
              $(this).removeData('state'); 

              var self = $(this);
              setTimeout(function() {
                  self.select2('close');
              }, 1);
          }    
      });


      $('.card_owner').change(function(){
        
        key = $(this).val();
        filter(0, key,'owner', function(o){
          if(o == 1){
            $change = 'yes';
          }
          else{
            $change = 'no';
          }
        });
        balance();
    })

    $('.card_id').change(function(){
        $change = 'yes';
        $('#detail_output').html('');
        key = $(this).val();
        filter(0, key , 'card', function(o){
          if(o == 1){
            $change = 'yes';
          }
          else{
            $change = 'no';
          }
        });
        balance();
      
    })


    //advance filter
    $('.date_from').on('changeDate', function() {
        var date_from = $('.date_from').datepicker('getFormattedDate');
        var date_to   = $('.date_to').datepicker('getFormattedDate');
        jsonAjax({json:json, date_from: date_from, date_to :date_to }, "action/date_filter.php", function(output){
          $('#detail_output').html('');
          $.each(output, function(k, v){
              if(v.t_charge == '0' ){
                tr_earn = v.t_earn
              }
              else{
                tr_earn = v.tr_earn
              }
                    $('#detail_output').append("<tr class='show-re pointer' card='"+v.card+"'>"+
                                "<td>"+moment(v.date_time).format('MM/DD/YYYY H:mm:ss')+"</td>"+
                                "<td>"+v.card+"</td>"+
                                "<td>"+v.owner+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_taste)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_charge)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_deposit)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_refund)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_earn)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(tr_earn)+"</td>"+
                            "</tr>")
            })

        })
        $limit = 50;
        balance();

    });
    $('.date_to').on('changeDate', function() {
        var date_from = $('.date_from').datepicker('getFormattedDate');
        var date_to   = $('.date_to').datepicker('getFormattedDate');
        jsonAjax({json:json, date_from: date_from, date_to :date_to }, "action/date_filter.php", function(output){
          $('#detail_output').html('');
          $.each(output, function(k, v){
              if(v.t_charge == '0' ){
                tr_earn = v.t_earn
              }
              else{
                tr_earn = v.tr_earn
              }
                    $('#detail_output').append("<tr class='show-re pointer' card='"+v.card+"'>"+
                                "<td>"+moment(v.date_time).format('MM/DD/YYYY H:mm:ss')+"</td>"+
                                "<td>"+v.card+"</td>"+
                                "<td>"+v.owner+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_taste)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_charge)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_deposit)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_refund)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(v.t_earn)+"</td>"+
                                "<td class='text-right'>"+commaSeparate(tr_earn)+"</td>"+
                            "</tr>")
            })

        })
        $limit = 50;
        balance();
    });


    $('.date').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true, orientation: "right"
    });

    $('.refresh').click(function(){
      window.location.reload();
    })

    $(document).on('click', '.show-re', function(){
        var card = $(this).attr('card');
        html  = '<div class="div-refer"><table class="table table-bordered table-refer">'+
          '<thead>'+
            '<tr>'+
              '<th>#</th>'+
              '<th>Date / Time</th>'+
              '<th>Card Owner</th>'+
              '<th>Action</th>'+
              '<th  class="text-center">Taste</th>'+
              '<th  class="text-center">Charge</th>'+
              '<th  class="text-center">Deposit</th>'+
              '<th  class="text-center">Refund</th>'+
              '<th  class="text-center">Earn</th>'+
            '</tr>'+
          '</thead>'+
          '<tbody>';
          
        jsonAjax({json: json, card: card}, 'action/card_info.php', function(output){
          i= 0;
          $.each(output , function (k,v){
            i++;
            html += '<tr>'+
                '<td>'+i+'.</td>'+
                '<td>'+moment(v.date_time).format('MM/DD/YYYY H:mm:ss')+'</td>'+
                '<td>'+v.owner+'</a></td>'+
                '<td>'+v.action+'</a></td>'+
                '<td class="text-right">'+v.taste+'</td>'+
                '<td class="text-right">'+v.charge+'</td>'+
                '<td class="text-right">'+v.deposit+'</td>'+
                '<td class="text-right">'+v.refund+'</td>'+
                '<td class="text-right">'+v.earn+'</td>'+
                '</tr>';
          })
          html += '</tbody></table></div>'; 
          $.dialog({
            title: 'Card ID : '+ card,
            content: html,
            boxWidth: '80%',
            useBootstrap: false
          });
          $('.table-refer').floatThead();
          $(window).keydown(function(event){
            if (event.keyCode == 13 | event.keyCode == 27) { $('.jconfirm-closeIcon').click(); }
          });
        })
        
      })
})
</script>
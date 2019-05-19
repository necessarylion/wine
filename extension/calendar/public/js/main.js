
function commaSeparate(val){
    if(val == 0 || val == null){
        return 0;
    }
    else{
        nStr = val;
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
	
}



		/////////for side bar //////////////////
	
		var res = alasql("SELECT * FROM ? order by id desc", [sidebar]);

		$.each(res, function(k,v){

			p_id = v.id;
			var c = alasql("SELECT * FROM ? where p_id =  ?  order by id desc", [child_sidebar, p_id]);
			
			if(c.length > 0){
				(v.divider == 1)?div ='<hr class="sidebar-divider">':div='';
				(v.display == 0 )?hid="style='display:none'":hid = ""; 
				$('.sidebar-detail').prepend('<li class="nav-item" id='+v.code+' '+hid+'>'+
											'<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#'+v.code+'_target" aria-expanded="true" aria-controls="collapseTwo">'+
												'<i class="fas fa-fw fa-'+v.icon+'"></i>'+
												'<span>'+v.name+'</span>'+
											'</a>'+
											'<div id="'+v.code+'_target" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">'+
												'<div class="bg-white py-2 collapse-inner rounded sub_sidebar'+v.id+'">'+
												'</div>'+
											'</div>'+
											'</li>'+div);
				//#############child ##################                       
				$.each(c, function(a,b){
					(b.link == 0)?link_c = "": link_c = "href='"+b.code+".php'";
					(b.display == 0 )?hid="style='display:none'":hid = ""; 

					$('.sub_sidebar'+v.id).prepend('<a '+link_c+' '+hid+' class="collapse-item" id="'+v.code+'" href="buttons.html"> '+b.name+'</a>');
				})
			}
			
			else{
				(v.link == 0)?link = "":link = "href='"+v.code+".php'";
				(v.display == 0 )?hid="style='display:none'":hid = ""; 
				(v.divider == 1)?div ='<hr class="sidebar-divider">':div='';
				$('.sidebar-detail').prepend('<li class="nav-item" id="'+v.code+'" '+hid+'>'+
											'<a '+link+' class="nav-link" href="">'+
												'<i class="fas fa-fw fa-'+v.icon+'"></i>'+
												'<span>'+v.name+'</span></a>'+
											'</li>'+div);
			}
		})
		/////////for side bar //////////////////
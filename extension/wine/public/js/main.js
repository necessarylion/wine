$('.date').datepicker({
    format: 'dd/mm/yyyy',
    todayHighlight: true,
    autoclose: true, orientation: "right"
});
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

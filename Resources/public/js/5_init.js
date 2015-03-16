$(function () {	
	if (typeof bnbc_ajax_file != 'undefined'){

		bnbcAjaxFileSetValue = function(value, new_value, separator){
			var result = new_value;
			if(value)
				result = value + separator + new_value;
			return result;
		}

		for (i = 0; i < bnbc_ajax_file.length; i++) {
		    bnbc_ajax_file[i]();
		}
	}
});
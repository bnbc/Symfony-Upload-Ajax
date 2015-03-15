$(function () {	
	if (typeof bnbc_ajax_file != 'undefined'){
		for (i = 0; i < bnbc_ajax_file.length; i++) {
		    bnbc_ajax_file[i]();
		}
	}
});
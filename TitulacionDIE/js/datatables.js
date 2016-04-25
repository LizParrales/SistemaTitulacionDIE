$(document).ready(function() {
    $('#tabla').dataTable({
    	"aoColumns":[
    		{ "bSortable": false },
    		{ "bSortable": false },
    		null,
    		null,
    		null,
    		{ "bSortable": false },
    		{ "bSortable": false },
    		{ "bSortable": false },
    		null,
    		null,
			null
    	]
    }).columnFilter();
} );
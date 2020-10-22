"use strict";
// Class definition

var KTDatatableHtmlTableDemoFournisseurs = function () {
	// Private functions

	// demo initializer
	var demo = function () {

		var datatable = $('#kt_datatable_fournisseurs').KTDatatable({
			data: {
				saveState: { cookie: false },
			},
			columns: [
				{
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 150,
					overflow: 'visible',
					autoHide: false,
				}
			],
		});

	};

	return {
		// Public functions
		init: function () {
			// init dmeo
			demo();
		},
	};
}();

jQuery(document).ready(function () {
	KTDatatableHtmlTableDemoFournisseurs.init();
});

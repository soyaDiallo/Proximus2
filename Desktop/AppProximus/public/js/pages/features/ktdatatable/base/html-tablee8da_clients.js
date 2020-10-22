"use strict";
// Class definition

var KTDatatableHtmlTableDemo = function () {
	// Private functions

	// demo initializer
	var demo = function () {

		var datatable = $('#kt_datatable').KTDatatable({
			data: {
				saveState: { cookie: false },
			},
			search: {
				input: $('#kt_datatable_search_query'),
				key: 'generalSearch'
			},
			columns: [
				{
					field: 'Type',
					title: 'Type Client',
					autoHide: false,
					// callback function support for column rendering
					template: function (row) {
						var type = {
							1: {
								'title': 'BTB',
								'class': ' label-light-success'
							},
							2: {
								'title': 'BTC',
								'class': ' label-light-warning'
							}
						};
						return '<span class="label font-weight-bold label-lg' + type[row.Type].class + ' label-inline">' + type[row.Type].title + '</span>';
					},
				}, {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 150,
					overflow: 'visible',
					autoHide: false,
				}
			],
		});

		$('#kt_datatable_search_statut').on('change', function () {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_statut').selectpicker();

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
	KTDatatableHtmlTableDemo.init();
});

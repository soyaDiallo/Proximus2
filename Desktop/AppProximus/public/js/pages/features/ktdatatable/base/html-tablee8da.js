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
					field: 'Statut',
					title: 'Statut',
					autoHide: false,
					// callback function support for column rendering
					template: function (row) {
						var statut = {
							1: {
								'title': 'Validée',
								'class': ' label-light-success'
							},
							2: {
								'title': 'Non-validée',
								'class': ' label-light-warning'
							},
							3: {
								'title': 'Annulée',
								'class': ' label-light-danger'
							}
						};
						return '<span class="label font-weight-bold label-lg' + statut[row.Statut].class + ' label-inline">' + statut[row.Statut].title + '</span>';
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
			datatable.search($(this).val().toLowerCase(), 'Statut');
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

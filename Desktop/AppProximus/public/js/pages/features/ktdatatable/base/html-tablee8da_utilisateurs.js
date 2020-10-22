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
					field: 'Role',
					title: 'Rôle',
					autoHide: false,
					// callback function support for column rendering
					template: function (row) {
						var role = {
							1: {
								'title': 'Agent',
								'class': ' label-light-success'
							},
							2: {
								'title': 'Superviseurs',
								'class': ' label-light-warning'
							},
							3: {
								'title': 'Back-Office',
								'class': ' label-light-danger'
							},
							4: {
								'title': 'Administrateur',
								'class': ' label-light-primary'
							}
						};
						return '<span class="label font-weight-bold label-lg' + role[row.Role].class + ' label-inline">' + role[row.Role].title + '</span>';
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
			datatable.search($(this).val().toLowerCase(), 'Role');
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

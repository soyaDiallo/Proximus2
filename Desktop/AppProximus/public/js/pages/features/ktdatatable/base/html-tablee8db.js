"use strict";
// Class definition

var KTDatatableHtmlTableDemoSuperviseur = function () {
	// Private functions

	// demo initializer
	var demo = function () {

		var datatable = $('#kt_datatable_superviseur').KTDatatable({
			data: {
				saveState: { cookie: false },
			},
			search: {
				input: $('#kt_datatable_search_query_superviseur'),
				key: 'generalSearch'
			},
			columns: [
				{
					field: 'StatutTingis',
					title: 'Statut Tingis',
					autoHide: false,
					// callback function support for column rendering
					template: function (row) {
						var statut = {
							1: {
								'title': 'Pending',
								'class': ' label-light-warning'
							},
							2: {
								'title': 'Delivered',
								'class': ' label-light-danger'
							},
							3: {
								'title': 'Canceled',
								'class': ' label-light-primary'
							},
							4: {
								'title': 'Success',
								'class': ' label-light-success'
							},
							5: {
								'title': 'Info',
								'class': ' label-light-info'
							},
							6: {
								'title': 'Danger',
								'class': ' label-light-danger'
							},
							7: {
								'title': 'Warning',
								'class': ' label-light-warning'
							}
						};
						return '<span class="label font-weight-bold label-lg' + statut[row.StatutTingis].class + ' label-inline">' + statut[row.StatutTingis].title + '</span>';
					},
				}, {
					field: 'Type',
					title: 'Statut Proximus',
					autoHide: false,
					// callback function support for column rendering
					template: function (row) {
						var statut = {
							1: {
								'title': 'Online',
								'state': 'danger'
							},
							2: {
								'title': 'Retail',
								'state': 'primary'
							},
							3: {
								'title': 'Direct',
								'state': 'success'
							},
						};
						return '<span class="label label-' + statut[row.Type].state + ' label-dot mr-2"></span><span class="font-weight-bold text-' + statut[row.Type].state + '">' + statut[row.Type].title + '</span>';
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



		$('#kt_datatable_search_statut_tingis_superviseur').on('change', function () {
			datatable.search($(this).val().toLowerCase(), 'StatutTingis');
		});

		$('#kt_datatable_search_statut_proximus_superviseur').on('change', function () {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_statut_tingis_superviseur, #kt_datatable_search_statut_proximus_superviseur').selectpicker();

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
	KTDatatableHtmlTableDemoSuperviseur.init();
});

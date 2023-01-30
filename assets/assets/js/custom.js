var handler = function (data) {
	return data;
};

function updateData(bookingId) {
	var ret = "";
	$.ajax({
		method: 'POST',
		url: '/api/v1/booking/api-update',
		async: false,
		dataType: 'json',
		data: { booking_id: bookingId },
		success: function (res) {
			if (res.status) {
				ret = res;
			} else {
				ret = res;
			}
		},
		error: function (err) {
			resp = err;
		}
	});

	return ret;
}

function verifyBtn(e) {

	const phoneNumber = $(e).data('phone');

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger mr-2'
		},
		buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
		title: 'Anda yakin?',
		text: "",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Verifikasi!',
		cancelButtonText: 'Batal!',
		reverseButtons: true
	}).then((result) => {
		var resp = '';
		if (result.isConfirmed) {
			$.ajax({
				url: '/api/v1/user/verify',
				method: 'POST',
				dataType: 'json',
				async: false,
				data: { phone: phoneNumber },
				success: function (res) {
					swalWithBootstrapButtons.fire(
						'Verified!',
						'User telah terverifikasi',
						'success'
					).then((rest) => {
						window.location.href = '/page/user';
					})
				},
				error: function (err) {

				}
			});
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {

		}
	})

}

function userDeleteBtn(e) {

	const id = $(e).data('id');

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger mr-2'
		},
		buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
		title: 'Anda yakin?',
		text: "hapus user",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ya!',
		cancelButtonText: 'Batal!',
		reverseButtons: true
	}).then((result) => {
		var resp = '';
		if (result.isConfirmed) {
			$.ajax({
				url: '/api/v1/user/delete',
				method: 'POST',
				dataType: 'json',
				async: false,
				data: { id: id },
				success: function (res) {
					swalWithBootstrapButtons.fire(
						'Sukses!',
						'User telah dihapus',
						'success'
					).then((rest) => {
						window.location.href = '/page/user';
					})
				},
				error: function (err) {

				}
			});
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {

		}
	})

}

function cancelBook(e) {
	const bookingId = $(e).data('book_id');
	// console.log(bookingId);

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger mr-2'
		},
		buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
		title: 'Anda yakin?',
		text: "Batalkan Booking",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ya!',
		cancelButtonText: 'Batal!',
		reverseButtons: true
	}).then((result) => {
		var resp = '';
		if (result.isConfirmed) {
			$.ajax({
				url: '/api/v1/booking/cancelWeb',
				method: 'POST',
				dataType: 'json',
				async: false,
				data: { booking_id: bookingId },
				success: function (res) {
					swalWithBootstrapButtons.fire(
						'Dibatalkan!',
						'Booking telah dibatalkan',
						'success'
					).then((rest) => {
						window.location.href = '/page/booking';
					})
				},
				error: function (err) {

				}
			});
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {

		}
	})
}

function deleteSchedule(e) {
	const id = $(e).data('sch_id');
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger mr-2'
		},
		buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
		title: 'Anda yakin?',
		text: "Hapus Jadwal",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ya!',
		cancelButtonText: 'Batal!',
		reverseButtons: true
	}).then((result) => {
		var resp = '';
		if (result.isConfirmed) {
			window.location.href = '/page/delete-schedule/' + id
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {

		}
	})
}

function deleteHoliday(e) {
	const id = $(e).data('usch_id');

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger mr-2'
		},
		buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
		title: 'Anda yakin?',
		text: "Hapus Jadwal",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ya!',
		cancelButtonText: 'Batal!',
		reverseButtons: true
	}).then((result) => {
		var resp = '';
		if (result.isConfirmed) {
			window.location.href = '/page/delete-holiday/' + id
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {

		}
	})
}

$(document).ready(function () {
	var currentLocation = window.location.href;

	var page = currentLocation.split('/')[4];

	if (page === 'booking-check') {
		$('#booking_code').focus();
	}

	$("#modalSuccess").on("hidden.bs.modal", function () {
		$('#booking_code').val('');
		$('#booking_code').focus();
	});

	$('#booking_code').keyup(function () {
		var bookingCode = $('#booking_code').val();

		$.ajax({
			url: '/api/v1/booking/get-booking?booking_code=' + bookingCode,
			dataType: 'json',
			success: function (res) {
				if (res.data?.length > 0) {
					// console.log('booking', res.data[0]?.booking_id);
					var call = updateData(res.data[0]?.booking_id);

					if (call?.status) {
						$('#modalSuccess').modal('show');
					} else {
						// console.log('something went wrong');
					}
					// console.log('res', call);
				} else {

					$('#booking_code').val('');
					$('#booking_code').focus();

					alert('booking tidak ditemukan');
				}

			},
			error: function (err) {
				// console.log(err);
			}
		});

		// 
	});

	$('#booking_dataTable').DataTable({
		order: [[5, 'desc']],
		autoWidth: false,
		language: {
			search: '',
			searchPlaceholder: 'Type to filter...',
			lengthMenu: '<span class="me-3">Show:</span> _MENU_',
			paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '←' : '→', 'previous': document.dir == "rtl" ? '→' : '←' }
		}
	});

	$('#bus_dataTable').DataTable({
		autoWidth: false,
		language: {
			search: '',
			searchPlaceholder: 'Type to filter...',
			lengthMenu: '<span class="me-3">Show:</span> _MENU_',
			paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '←' : '→', 'previous': document.dir == "rtl" ? '→' : '←' }
		}
	});


	$('#user_dataTable').DataTable({
		autoWidth: false,
		language: {
			search: '',
			searchPlaceholder: 'Type to filter...',
			lengthMenu: '<span class="me-3">Show:</span> _MENU_',
			paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '←' : '→', 'previous': document.dir == "rtl" ? '→' : '←' }
		}
	});



	// $('.datatable-basic').DataTable({
	// 	autoWidth: false,
	// 	language: {
	// 		search: '',
	// 		searchPlaceholder: 'Type to filter...',
	// 		lengthMenu: '<span class="me-3">Show:</span> _MENU_',
	// 		paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '←' : '→', 'previous': document.dir == "rtl" ? '→' : '←' }
	// 	}
	// });

});

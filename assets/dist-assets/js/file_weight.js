$(document).on('change', 'input[type="file"]', function () {
	// this.files[0].size recupera el tamaño del archivo
	// alert(this.files[0].size);
	var fileName = this.files[0].name;
	var fileSize = this.files[0].size;
	if (fileSize > 10000000) {
		toastr.error("El Archivo No Debe Superrar Los 10 MB", "Informacion", {
			progressBar: 100,
			showMethod: "slideDown",
			hideMethod: "slideUp",
			timeOut: 3000
		});
		this.value = '';
		this.files[0].name = '';
	}
});

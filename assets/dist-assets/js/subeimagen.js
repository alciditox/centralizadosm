/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/

$(".nuevaImagen").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	//if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
	if(imagen["type"] != "application/pdf"){

  		$(".nuevaImagen").val("");
			
        toastr.error("¡El archivo debe estar en formato PDF!", "Danger", {
            progressBar: 100,
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 4500
        });

  	}else if(imagen["size"] > 100000){

  		$(".nuevaImagen").val("");
			
        toastr.error("¡El archivo no debe pesar más de 2MB!", "Danger", {
            progressBar: 100,
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 4500
        });

  	}/*else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}*/
});

$(".soloExcel").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	//if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
	if(imagen["type"] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){

  		$(".soloExcel").val("");
			
        toastr.error("¡El archivo debe estar en formato Excell!", "Danger", {
            progressBar: 100,
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 4500
        });

  	}else if(imagen["size"] > 2000000){

  		$(".soloExcel").val("");
			
        toastr.error("¡El archivo no debe pesar más de 2MB!", "Danger", {
            progressBar: 100,
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 4500
        });

  	}/*else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}*/
});

$(".soloPdf").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	//if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
	if(imagen["type"] != "application/pdf"){

  		$(".soloExcel").val("");
			
        toastr.error("¡El archivo debe estar en formato Excell!", "Danger", {
            progressBar: 100,
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 4500
        });

  	}else if(imagen["size"] > 2000000){

  		$(".soloExcel").val("");
			
        toastr.error("¡El archivo no debe pesar más de 2MB!", "Danger", {
            progressBar: 100,
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 4500
        });

  	}/*else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}*/
});
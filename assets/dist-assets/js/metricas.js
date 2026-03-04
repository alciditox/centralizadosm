$('.rif').keyup(function () {
	this.value = this.value.toUpperCase();
});

$('#rif').on('blur', function (e) {
	var number_doc = e.target.value;
	var parts = number_doc.split("-");

	if (parts.length == 2) {
		var index = parts[1].substr(-1);
		parts[2] = index;
		parts[1] = parts[1].slice(0, -1);
		parts[1] = parts[1].padStart(8, '0');
	} else {
		if (parts.length > 2) {
			if (parts[2] == "") {
				var index = parts[1].substr(-1);
				parts[2] = index;
				parts[1] = parts[1].slice(0, -1);
				parts[1] = parts[1].padStart(8, '0');
			}
		}
	}
	document.getElementById("rif").value = parts.join("-");
});

$('.rif').mask('S-AAAAAAAA-Y', {
	'translation': {
		S: {
			pattern: /[VEJPGCvejpgc]{1}/
		},
		A: {
			pattern: /[0-9]/
		},
		Y: {
			pattern: /[0-9]/,
			optional: true
		}
	}
});

jQuery(document).ready(function () {
	$('.only-number').on('input', function () {
		this.value = this.value.replace(/[^0-9]/g, '');
	});
	
	$('.letters').on('input', function () {
		this.value = this.value.replace(/[^a-zA-Z ]+$/, '');
	});
	
	$('.notspace').on('input', function () {
		this.value = this.value.replace(/[^a-zA-Z]+$/, '');
	});
	
	$('.letter').keyup(function () {
	this.value = this.value.toLowerCase();
	this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
	});
	
    $('.minusculas').keyup(function () {
	this.value = this.value.toLowerCase();
	});
	
	$('.mayusculas').keyup(function () {
	this.value = this.value.toUpperCase();
	});

	$('.mayusc').keyup(function () {
		this.value = this.value.toUpperCase();
	});

	$('.money').mask('000,000,000,000.00', {
		reverse: true
	});

	$('.telephone').mask('STAA-AAAAAAA', {
		'translation': {
			S: {
				pattern: /[0]/
			},
			T: {
				pattern: /[2]/
			},
			A: {
				pattern: /[0-9]/
			}
		}
	});

	$('.other-phone').mask('STAA-AAAAAAA', {
		'translation': {
			S: {
				pattern: /[0]/
			},
			T: {
				pattern: /[2,4]/
			},
			A: {
				pattern: /[0-9]/
			}
		}
	});

	$('.phone').mask('STBY-AAAAAAA', {
		'translation': {
			S: {
				pattern: /[0]/
			},
			T: {
				pattern: /[4]/
			},
			B: {
				pattern: /[1,2]/
			},
			Y: {
				pattern: /[2,4,6]/
			},
			A: {
				pattern: /[0-9]/
			}
		}
	});

	$('.bankcode').mask('SSSS-TTTT-AAAAAAAA-BBBB', {
		'translation': {
			S: {
				pattern: /[0-9]/
			},
			T: {
				pattern: /[0-9]/
			},
			A: {
				pattern: /[0-9]/
			},
			B: {
				pattern: /[0-9]/
			}
		}
	});

	$('.cedula').keyup(function () {
		this.value = this.value.toUpperCase();
	});

	$('.cedula').mask('SAAAAAAAA', {
		'translation': {
			S: {
				pattern: /[VEve]{1}/
			},
			A: {
				pattern: /[0-9]/
			},
			Y: {
				pattern: /[0-9]/,
				optional: true
			}
		}
	});
	
	//no seleccionar una fecha mayor al dia actual
    var myDate = $('.no-dia-mayor');
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10)
        dd = '0' + dd;

    if (mm < 10)
        mm = '0' + mm;

    today = yyyy + '-' + mm + '-' + dd;
    myDate.attr("max", today);

    function myFunction() {
        var date = myDate.val();
        if (Date.parse(date)) {
            if (date > today) {
                alert('La fecha no puede ser mayor a la actual');
                myDate.val("");
            }
        }
    }	

$(document).ready(function(){
  $(".nocopy").on('paste', function(e){
    e.preventDefault();
    alert('Esta acción está prohibida');
  })
  
  $(".nocopy").on('copy', function(e){
    e.preventDefault();
    alert('Esta acción está prohibida');
  })
})


});





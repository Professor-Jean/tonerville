// Criando mascaras padrões para o pluguin jQuery Mask


// tirando as máscaras na hora de enviar
function removeMasks() {
	$('.phone_mask').unmask();
	$('.cep_mask').unmask();
	$('.cnpj_mask').unmask();
};

$(document).ready(function() {

	var PhoneMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
		},
		phoneOptions = {
			onKeyPress: function (val, e, field, options) {
				field.mask(PhoneMaskBehavior.apply({}, arguments), options);
			}
		};

	$('.phone_mask').mask(PhoneMaskBehavior, phoneOptions);

	$('.cep_mask').mask('00000-000');
	$('.cnpj_mask').mask('00.000.000/0000-00', {reverse: true});
	$('.money_mask').mask("\R\$ #.##0,00", {reverse: true});
	
	// tirando as máscaras opcionais quando não tiver
	$.each($('.optional_mask'), function(){
		if ($(this).html() == ""){
			$(this).html("-");
		}
	});
	
});
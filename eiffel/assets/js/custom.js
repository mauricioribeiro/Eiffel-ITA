/* events */ 
//var EIFFEL_URL = 'http://localhost/calc/';
var EIFFEL_URL = 'http://161.24.12.204:9090/calc/';

$(document).ready(function(){ 

	$('.input-double').mask('000000000000.00', {reverse: true});
	$('body').on('blur','input[type="text"]',function(){
		if($(this).val()) listen($(this));
	});
	$('body').on('change','select',function(){
		if($(this).val()) listen($(this));
	});
	$('body').on('click','input[type="checkbox"]',function(){ 
		listen($(this));
	});
	$('body').on('blur','input[type="number"]',function(){
		var v = parseFloat($(this).val());
		if(v > parseFloat($(this).attr('max'))) {
			$(this).val(parseFloat($(this).attr('max')).toFixed(2));
		}
		if(v < parseFloat($(this).attr('min'))) {
			$(this).val(parseFloat($(this).attr('min')).toFixed(2));
		}
		listen($(this));
	});

	//Verificação
	$('body').on('change','#Componente',function(){
		if($(this).val()){
			$.ajax({
				url: 'inc/verificacao-data.php',
				data : { 'Componente' : $(this).val() },
			  	type : 'GET',
			  	dataType: 'JSON',
			  	success: function (r) {
					$('#targetAco').html(json2select('Aco',r.Aco));
					$('#targetSecao').html(json2select('Secao',r.Secao));
				}
			});
		}
	});

	$('body').on('change','#Secao',function(){
		if($(this).val()){
			$.ajax({
				url: 'inc/verificacao-data.php',
				data : { 'Secao' : $(this).val(), 'Componente' : $('#Componente').val() },
			  	type : 'GET',
			  	dataType: 'JSON',
			  	success: function (r) {
					$('#targetBitola').html(json2select('Bitola',r.Bitola));
				}
			});
		}
	});

	//Solicitação
	$('.toggle-form').click(function(){
		if($(this).is(":checked")){
			$(this).parent().parent().find('.dynamic-form-content').show();
		} else {
			$(this).parent().parent().find('.dynamic-form-content').hide();
		}
	});

	//Resistência
	$('body').on('click','.btn-verificar',function(){
		var f = $(this).attr('id');
		calcular(f);
	});

	$('body').on('click','#verificarCombinado',function(){
		var idVerificar = $(this).attr('id');
		$('#'+idVerificar+'-resumo').hide();
		$.ajax({
			url: 'inc/combinacao-data.php',
		  	type : 'GET',
		  	success: function (r) {
				$('#'+idVerificar+'-resumo').html(r).fadeIn();
			}
		});
	});

	//Relatório
	$('#generatePDF').click(function(){
		var pdf = new jsPDF('p','in','ledger');
		source = $('#relatorioPDF')[0];
		specialElementHandlers = { '#bypassme': function(element, renderer){ return true; } }
		pdf.fromHTML(
			source // HTML string or DOM elem ref.
			, 0.5 // x coord
			, 0.5 // y coord
			, {
				'width':7.5 // max width of content on PDF
				, 'elementHandlers': specialElementHandlers
			}
		)
		pdf.save('Eiffel Relatório.pdf');
	});

});

function json2select(selectName,jsonData){
	var attr = (jsonData.length > 1) ? '' : 'disabled';
	var r = '<select id="'+selectName+'" name="'+selectName+'" class="form-control" '+attr+'>';
	for(var i = 0; i < jsonData.length; i++){
		r += '<option value="'+jsonData[i].v+'">'+jsonData[i].t+'</option>';
	}
	r += '</select>';
	return r;
}

function listen(input){
	var key = input.attr('name');
	var val = 0;
	if(input.attr('type') == 'checkbox'){
		val = (input.is(':checked')) ? input.val() : 0;
	} else {
		val = input.val();
	}
	$.ajax({
		url: 'inc/session-listener.php',
		data : { 'key' : key, 'val' : val },
	  	type : 'GET',
	  	//dataType: 'JSON',
	  	success: function () {
			//console.log(input.attr('name')+ ' was updated to '+val);
		}
	});
}

function calcular(funcao){
	$('#'+funcao+'-resumo').hide();
	$.ajax({
		url: 'inc/resistencia-data.php',
		data : { 'funcao' : funcao },
	  	type : 'GET',
	  	success: function (r) {
			$('#'+funcao+'-resumo').html(r).fadeIn();
		}
	});
}
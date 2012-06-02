$(document).ready(function() {
	$("input:checkbox, input:radio, input:file, select").uniform();
	$('a.SendButton, a.CancelButton').bind('click', function() {
		var FormSubmitID = (this.id).split('_');
		$('#'+FormSubmitID[1]).submit();
	});
	$(".valid, .error, .info, .status").each(function () {
		var GetStatus = $(this).attr("class");
		$(this).addClass("close-" +GetStatus);
		$(".close-" +GetStatus).click(function () {
			$(this).fadeOut("slow");
		});
	});


    $("select[name=localeset]").change(function () {
		var ChengeLang = $("select[name=localeset] option:selected").val();
		if(ChengeLang == "Polish" || ChengeLang == "Polish-utf8") {
			$("#AcceptLink").attr('href', 'http://extreme-fusion.org/ef5/license/');
			$("#AcceptLink").html('Akceptuje warunki licencji BSD');
		} else {
			$("#AcceptLink").attr('href', 'http://extreme-fusion.org/ef5/license/');
			$("#AcceptLink").html('I accept BSD License');
		}
	});

	$('input:checkbox[name=AcceptCC]').click(function() {
		if($('input:checkbox[name=AcceptCC]:checked').length > 0) {
			$("#SendForm_This").show();
		} else {
			$("#SendForm_This").hide();
		}
	});

	var bpos = "";
	var perc = 0 ;
	var minperc = 0 ;
	$('#password1, #admin_password1').css({backgroundPosition: "0 0"});
	$('#password1').keyup(function(){
		perc = passwordStrengthPercent($('#password1').val(),$('#username').val());
		bpos=" $('#colorbar').css( {backgroundPosition: \"0px -" ;
		bpos = bpos + perc + "px";
		bpos = bpos + "\" } );";
		bpos=bpos +" $('#colorbar').css( {width: \"" ;
		bpos = bpos + (perc * 3) + "px";
		bpos = bpos + "\" } );";
		eval(bpos);
	    	$('#percent').html(" " + perc  + "% ");
	});

	/** Team section **/
	$('#team-tab').click(function() {
		$object = $('#ef-crew');
		if ($object.is(':hidden')) {
			$object.fadeIn();
		} else {
			$object.fadeOut();
		}
	});
	/**/

});
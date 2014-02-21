var AjRunning = false,  ctime;
$(document).ready(function(){
	$('.fancy').fancybox({
		autoResize:  true,
		autoCenter:  true,
		afterShow: function(){			
			$('form').each(function(){
				$(this).validate();
			});
		}
	});
	$('form').each(function(){
		$(this).validate();
	});
	
	$('body').on('click', '#instafetch', function(e){
		e.preventDefault();
		$(this).parent().html('<h2>Loading...</h2>');
		$('.insta-content').load($(this).attr('href'), function(){
			$(window).scroll(function(){
				if($(window).scrollTop() > 100){
					$('#photoForm .action').addClass('float')
				}else{
					$('#photoForm .action').removeClass('float');
				}
			});
		});
	})
	
	$('body').on('click', '#paging', function(e){
		e.preventDefault();
		$parent = $(this).parent();
		$parent.html('<img src="'+BASEURL+'/images/load.gif" />');
		$.get( $(this).attr('href'), function(data) {
			$parent.remove();
			$('ul.instafeed').append(data);
		});
	})
	
	$('body').on('click', '.image-check', function(e){
		$(this).toggleClass('active');
		$(this).parent().find('input').trigger('click');
	});
	$('body').on('submit', '#photoForm', function(e){
		e.preventDefault();
		var frm = $(this);
		var url = $(this).attr('action');
		var qstr = frm.serializeObject();
		var total = 0;
		var cur = 0;
		if(!AjRunning){
			AjRunning = true;
			var $pData = qstr.inta_image;
			$.each( $pData , function(k,v){
				if(v !== undefined){
					v.eid = qstr.eid;
					$.ajax({
						url: url,
						data: v,
						type: "POST",
						dataType : "JSON",
						success: function( data){
							AjRunning = false;
							console.log(data);
							if(data.status == "success"){
								cur++;
								$('#photoForm').find('.status').html(cur + " out of " + total + " completed");
								if(cur == total){
									location.href = data.redirect;
								}
							}else{
								alert("An unexpected error occured, Please try agnail");
							}
						},
						error: function(x, t, m) {
							if(t==="timeout") {
								alert("got timeout");
							} else {
								alert(t);
							}
						}
					});
					total++;
				}
			});
			$('#photoForm').find('.status').html(cur + " out of " + total + " completed");
		};
	})
});
$(window).resize(function(){
	$.fancybox.update()
});

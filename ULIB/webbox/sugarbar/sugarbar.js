window.requestAnimationFrame = window.requestAnimationFrame
                               || window.mozRequestAnimationFrame
                               || window.webkitRequestAnimationFrame
                               || window.msRequestAnimationFrame
                               || function(f){return setTimeout(f, 1000/60)}

window.cancelAnimationFrame = window.cancelAnimationFrame
                              || window.mozCancelAnimationFrame
                              || function(requestID){clearTimeout(requestID)} //fall back

var sugarbar = (function($){

	var defaults = {
		showafter: 100,
		showdelay: 50,
		persistclose: false
	}

	var sugarcount = 0 // variable to count current instance of sugarbar

	function sugarbar(setting){

		var s = $.extend({}, defaults, setting)
		var $sugarbar
		var state = 'hidden'
		var contentdfd = $.Deferred()
		var scrollrequest, showbartimer, hidebartimer
		var sugarinstance = this

		function handlescroll(){
			var docscrolltop = window.pageYOffset || $(window).scrollTop()
			if (docscrolltop > s.showafter && state == 'hidden'){
				sugarinstance.showhidebar('show')
			}
			else if (docscrolltop < s.showafter && state == 'visible'){
				sugarinstance.showhidebar('hide')
			}
		}

		function handlecontent(id, file){
			if (!file){
				$sugarbar = $(id) // reference bar by ID
				contentdfd.resolve()
			}
			else{ // ajax content
				$.ajax({
					url: file,
					dataType: 'html',
					error:function(ajaxrequest){
						alert('Error fetching content.<br />Server Response: '+ajaxrequest.responseText)
						contentdfd.reject()
					},
					success:function(content){
						$sugarbar = $(content).appendTo(document.body)
						contentdfd.resolve()
					}
				})
			}
			return contentdfd
		}

		function handlecookie(name, action){
			if (action == 'get'){
				var re=new RegExp(name+"=[^;]+", "i") //construct RE to search for target name/value pair
				if (document.cookie.match(re)) //if cookie found
					return document.cookie.match(re)[0].split("=")[1] //return its value
				return null
			}
			else{
				document.cookie = name + "=" + action + "; path=/"
			}
		}

		this.showhidebar = function(action, persist){
			clearTimeout(showbartimer)
			clearTimeout(hidebartimer)
			if (action == 'show'){
				showbartimer = setTimeout(function(){
					$sugarbar.css('top', 0)
					state = 'visible'		
				}, s.showdelay)
			}
			else{
				hidebartimer = setTimeout(function(){
					$sugarbar.css('top', '-100%')
					state = 'hidden'
					if (persist){
						handlecookie(s.sugarbarid, 'set')
					}
				}, s.showdelay)
			}
		}

		if ( !s.persistclose || !handlecookie(s.sugarbarid, 'get') ){
			$.when( handlecontent(s.sugarbarid, s.externalfile) ).then(function(){
				$sugarbar.find('.sugarclose').on('click', function(e){
					sugarinstance.showhidebar('hide', true)
					$(window).off('scroll.' + s.sugarbarid)
				})
				$(window).on('scroll.' + s.sugarbarid, function(){
					scrollrequest = requestAnimationFrame(handlescroll)
				})
			})
		}
		
	}


	return sugarbar

})(jQuery)
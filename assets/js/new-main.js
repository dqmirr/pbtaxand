$(function(){
	$('#logout_button').on('click', function(){
		if ($(this).data('override') == 1) return false;
		
		$.ajax({
			dataType: 'json',
			error: function(data) {
				$('#modal_title').html('Alert')
				$('#msg').html("Silahkan coba beberapa saat lagi.")
				$('#modal').modal('show')
			},
			success: function(data) {
				if (data.redirect) {
					localStorage.clear()
					deleteAllCookies()
					window.location.href = data.redirect
				}
			},
			type: 'POST',
			url: logoutUrl
		})
	})
})

function setCookie(cname, cvalue, exdays) {
	if (exdays == undefined) exdays = 1
    var d = new Date();
    d.setTime(d.getTime() + (exdays*7*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function deleteAllCookies() {
	const cookies = document.cookie.split(";");
	
	for (let i = 0; i < cookies.length; i++) {
		const cookie = cookies[i].trim();
		const eqPos = cookie.indexOf("=");
		const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
		document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
	}
}

function deleteCookie(name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
};

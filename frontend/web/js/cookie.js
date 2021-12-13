$(document).ready(function() {
    $('#close-alert').click(function(e){
        let date = new Date(Date.now() + 86400e3 * 365);
        date = date.toUTCString();
        document.cookie = "CookieNoticeDisabled=1; path=/; secure; samesite=strict; expires=" + date;
        $('#cookie_alert').hide();
    })
});

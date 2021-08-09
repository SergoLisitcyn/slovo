$(document).ready(function(){

    $(".pf-pic").hover(function(){
        $('.pmop-edit').fadeToggle();
    });

    $(".update-btn-summary").on("click",function () {
        $("#summary-text").toggle();
        $("#summary-form").toggle();
    });

    $("button[data-ma-action]").on("click",function () {
        var type = $(this).data("ma-action");
        if (type == "summary-edit-cancel") {
            $("#summary-text").toggle();
            $("#summary-form").toggle();
        }
        if (type == "basic-edit-cancel") {
            $("#basic-text").toggle();
            $("#basic-form").toggle();
        }
        if (type == "contact-edit-cancel") {
            $("#contact-text").toggle();
            $("#contact-form").toggle();
        }
    });

    $(".update-btn-basic").on("click",function () {
        $("#basic-text").toggle();
        $("#basic-form").toggle();
    });

    $(".update-btn-contact").on("click",function () {
        $("#contact-text").toggle();
        $("#contact-form").toggle();
    });
});


function saveSummary() {
    var summary = $("#summary").val();
    if (!summary) {
        $("#summary").css("border","1px solid rgba(244, 67, 54, 0.75)");
        return false;
    }
    $.ajax({
        dataType: "json",
        url: '/admin/profile/update',
        type:'POST',
        data: {
            UserProfile: {
                about_me:summary,
            },
        },
        cache: false,
        success: function(response) {
            if (response) {
                $("#summary-form").toggle();
                $("#summary-text").text(summary).toggle();
                return true;
            } else {
                $("#summary-form").css("border","1px solid rgba(244, 67, 54, 0.75)");
                return false;
            }
        }
    });
}
function saveBasicInfo() {
    var fullName = $("#fullName").val();
    var gender = $("#gender").val();
    var birthday = $("#birthday").val();
    var martialStatus = $("#martialStatus").val();
    var position = $("#position").val();
    if (!fullName) {
        fullName = "";
    }
    if (!gender) {
        gender = "";
    }
    if (!birthday) {
        birthday = "";
    }
    if (!martialStatus) {
        martialStatus = "";
    }
    if (!position) {
        position = "";
    }
    var data = {
        UserProfile: {
            full_name:fullName,
            gender:gender,
            birthday:birthday,
            martial_status:martialStatus,
            profession:position,
        }
    };
    $.ajax({
        dataType: "json",
        url: '/admin/profile/update',
        type:'POST',
        data: data,
        cache: false,
        success: function(response) {
            if (response) {
                $("#basic-form").toggle();

                $(".fullName").text(fullName);
                $(".gender").text(gender);
                $(".birthday").text(birthday);
                $(".martialStatus").text(martialStatus);
                $(".position").text(position);

                $("#basic-text").toggle();
                return true;
            } else {
                $("#basic-form").css("border","1px solid rgba(244, 67, 54, 0.75)");
                return false;
            }
        }
    });
}
function saveContacts() {
    var phone = $("#phone").val();
    var public_email = $("#public_email").val();
    var address = $("#address").val();
    var facebook = $("#facebook").val();
    var twitter = $("#twitter").val();
    var skype = $("#skype").val();

    if (!phone) {
        phone = "";
    }
    if (!public_email) {
        public_email = "";
    }
    if (!facebook) {
        facebook = "";
    }
    if (!address) {
        address = "";
    }
    if (!twitter) {
        twitter = "";
    }
    if (!skype) {
        skype = "";
    }

    var data = {
        UserProfile: {
            phone:phone,
            public_email:public_email,
            address:address,
            facebook:facebook,
            twitter:twitter,
            skype:skype,
        }
    };
    $.ajax({
        dataType: "json",
        url: '/admin/profile/update',
        type:'POST',
        data: data,
        cache: false,
        success: function(response) {
            if (response) {
                $("#contact-form").toggle();

                $(".phone").text(phone);
                $(".public_email").text(public_email);
                $(".address").text(address);
                $(".facebook").text(facebook);
                $(".twitter").text(twitter);
                $(".skype").text(skype);

                $("#contact-text").toggle();
                return true;
            } else {
                $("#contact-form").css("border","1px solid rgba(244, 67, 54, 0.75)");
                return false;
            }
        }
    });
}
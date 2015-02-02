$(".response").hide("slow");
$(".header_send").click(function () {

    var name = $(this).parents(".gorizont_form").find(".name");
    var email = $(this).parents(".gorizont_form").find(".email");
    $.ajax({
        type: 'POST',
        url: 'ajax/ajax.php',
        data: {
            'name': name.val(),
            'email': email.val()
        },
        dataType: 'json',
        success: $.proxy(function (data) {

            if (data.error === false) {
                $(".response").html(data.response).addClass("valid");
                $(".response").show("slow");
                $(".form-inline").remove(".form-inline");
            } else {
                if (data.name !== false) {
                    $(".name").removeClass("valid").addClass("error");
                } else {
                    $(".name").removeClass("error").addClass("valid");
                }
                if (data.email !== false) {
                    $(".email").removeClass("valid").addClass("error");
                } else {
                    $(".email").removeClass("error").addClass("valid");
                }
            }

        })
    });
});
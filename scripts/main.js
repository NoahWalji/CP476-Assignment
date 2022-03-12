$(document).ready(function() {
    $("#logoutButton").click(function() {
        $.ajax({
            url: "classes/Ajax.php",
            type: "POST",
            data: {ajaxCall: "logout"},
            success: function(response){
                location.reload();
            }
        });
    });
});
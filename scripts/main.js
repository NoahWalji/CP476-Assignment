$(document).ready(function() {

    jQuery(function($) {
        var webSocket = new WebSocket("ws://localhost");
        webSocket.onerror = function(e) {

        }
        webSocket.onmessage = function(e) {
            var json = JSON.parse(e.data);
            console.log(json);
        }
        $("#sendMessage").submit(function( event ) {
            event.preventDefault();
            webSocket.send(JSON.stringify({
                'message':$("#message").val()
            }))
          });
    })
    // Loads Channel List
    if ($(".channelList").length) {
        $.ajax({
            url: "classes/Ajax.php",
            type: "POST",
            data: {ajaxCall: "getChannels"},
            success: function(response){
                var channels = JSON.parse(response);
                for (var channel of channels) {
                    $(".channelList").append("<button type='button' class='channelItem list-group-item list-group-item-action'>"+channel+"</button>")
                }
            }
        });
    }

    $(document).on('click', '.channelItem',function() {
        console.log($(this).text());
        $.ajax({
            url: "classes/Ajax.php",
            type: "POST",
            data: {ajaxCall: "getMessages", channelName: $(this).text()},
            success: function(response){
                var messages = JSON.parse(response);
                $(".messagesGroup").empty();
                for (var message of messages) {
                    $(".messagesGroup").append("<li class='list-group-item'><img src='"+message.profile_image+"' width='50' height='50'>"
                    +message.nickname+" | "+message.time+"<br>"
                    +message.contents+"</li>")
                }
            }
        });
    });


    // Runs Logout Script When a user Clicks Logout
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

    // Account Settings: Previews Profile Picture Change Before Saving
    $('#pfp-upload').change(function(){ 
        var file = $(this).get(0).files[0];

        if(file){
            var reader = new FileReader();
    
            reader.onload = function(){
                $(".settings-pfp").attr("src", reader.result);
            }
    
            reader.readAsDataURL(file);
        }
     });

});

function previewFile(input){

}
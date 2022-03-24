$(document).ready(function() {
    var value = "";
    jQuery(function($) {
        var webSocket = new WebSocket("ws://localhost");
        webSocket.onerror = function(e) {

        }
        webSocket.onmessage = function(e) {
            var json = JSON.parse(JSON.parse(e.data));
            if (json.type == "message") {
                // Get New Message if On Same Channel
                if (value == json.channel) {
                    $(".messagesGroup").append("<li class='list-group-item'><img src='"+json.profile_image+"' width='50' height='50'>"
                    +json.author+" | "+json.time+"<br>"
                    +json.message+"</li>")
                }
            }

            else if (json.type == "channel") {
                $(".channelList").append("<button type='button' class='channelItem list-group-item list-group-item-action'>"+json.name+"</button>")
            }

        }
        $("#sendMessage").submit(function( event ) {
            event.preventDefault();
            $("#error-message").hide();
            if (value == "") {
                $("#error-message").show();
                return;
            }

            webSocket.send(JSON.stringify({
                'type': "message",
                'author': $("#userNameValue").text(),
                'uid': $("#uidValue").text(),
                'channel':value,
                'message':$("#message").val(),
                "profile_image":$("#pfpValue").text(),
                "time": new Date().toISOString().replace(/T/, ' ').replace(/\..+/, ''),
            }))
            $.ajax({
                url: "classes/Ajax.php",
                type: "POST",
                data: {ajaxCall: "sendMessage", 'uid' : $("#uidValue").text(), 'channel':value, 'message':$("#message").val(),},
                success: function(response){
                    console.log(response);
                }
            });
            if (value != "") {
                const messageSent = new Date().toISOString().replace(/T/, ' ').replace(/\..+/, '');
                $(".messagesGroup").append("<li class='list-group-item'><img src='"+$("#pfpValue").text()+"' width='50' height='50'>"
                +$("#userNameValue").text()+" | "+messageSent+"<br>"
                +$("#message").val()+"</li>")
            }
            $("#message").val("");
          });

          $("#addChannelForm").submit(function (event) {
            event.preventDefault();
            webSocket.send(JSON.stringify({
              'type': "channel",
              'name': $("#channelName").val(),
            }))
            this.submit();
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
        value = $(this).text();
        $(this).addClass('active').siblings().removeClass('active');
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

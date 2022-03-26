$(document).ready(function() {
    var value = "";
    var myInterval;
    jQuery(function($) {
        $("#sendMessage").submit(function( event ) {
            event.preventDefault();
            $("#error-message").hide();
            if (value == "") {
                $("#error-message").show();
                return;
            }

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
        if (myInterval) {
            console.log("Clearing")
            clearInterval(myInterval);
            myInterval = null;
        }
        loadMessages($(this).text());
        myInterval = setInterval(loadMessages, 5000, $(this).text());

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

function loadMessages(channel){
    console.log(channel);
    $.ajax({
        url: "classes/Ajax.php",
        type: "POST",
        data: {ajaxCall: "getMessages", channelName: channel},
        success: function(response){
            var messages = JSON.parse(response);
            var list = "";
            for (var message of messages) {
                list = list + "<li class='list-group-item'><img src='"+message.profile_image+"' width='50' height='50'>"
                +message.nickname+" | "+message.time+"<br>"
                +message.contents+"</li>";
            }
            if ($(".messagesGroup").html() != list) {
                $(".messagesGroup").empty();
                $(".messagesGroup").append(list);
            }

        }
    });

}

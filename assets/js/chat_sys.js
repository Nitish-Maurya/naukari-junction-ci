$(document).ready(function(){
    var base_url = $('#chatbase_url').val();
    var ChatInterval = '';

    $(document).on('click', '.jp_open_chat_box', function(e){
        $('.jp_chat_wrapper').addClass('open_chatbox');
        chat_history($(this).data('sid'), $(this).data('rid'));
        ChatInterval = setInterval(showMessage, 2000);
    });

    $(document).on('click', '.jp_chat_close_window', function(e){
        $('.jp_chat_wrapper').removeClass('open_chatbox');
        clearInterval(ChatInterval);
    });

    $(document).keypress(function(e) {
        if(e.which == 13) {
            if($.trim($('.jp_chat_type_message').val()) != ''){
                var msg = $.trim($('.jp_chat_type_message').val());
                $('.jp_chat_type_message').val('');
                var rid = $('.jp_chat_type_message').attr('data-rid');
                var sid = $('.jp_chat_type_message').attr('data-sid');
                sendmessage(msg,sid,rid);
            }
        }
    });

    $(document).on('click', '.jp_chat_submit', function(e) {
        if($.trim($('.jp_chat_type_message').val()) != ''){
            var msg = $.trim($('.jp_chat_type_message').val());
            $('.jp_chat_type_message').val('');
            var rid = $('.jp_chat_type_message').attr('data-rid');
            var sid = $('.jp_chat_type_message').attr('data-sid');
            sendmessage(msg,sid,rid);
        }
    });

    $(document).on("paste", ".jp_chat_type_message", function(e) {
        e.preventDefault();
        var pasteText = e.originalEvent.clipboardData.getData("text/plain");
        document.execCommand("insertHTML", !1, pasteText);
    });

    function sendmessage(msg,sid,rid){
        $.ajax({
            url  :  base_url+'chat/send_message',
            data : { 'user_from' : sid, 'user_to' : rid, 'user_msg' : msg },
            type : 'post',
            success : function(result){
                var results = jQuery.parseJSON(result); 
                if(results.status){
                    $('.jp_chat_content').prepend(results.html);
                    $('.jp_chat_type_message').attr('data-msgid',results.msgid);
                    // setTimeout(function(){
                    //     ChatInterval = setInterval(showMessage, 2000);
                    // },1000);
                }else{
                    alert('Server Error.');
                }
            }
        });	
    }

    function chat_history(sid, rid){     
        $.ajax({
            url  :  base_url+'chat/getchathistory',
            data : { 'user_to' : rid, 'user_from' : sid },
            type : 'post',
            success : function(result){
                var results = jQuery.parseJSON(result); 
                if(results.status){
                    $('.jp_chat_wrapper').html(results.html);
                }
            }
        });	
    };

    function showMessage(){
        var msg_id = $('.jp_chat_type_message').attr('data-msgid');
        var sid = $('.jp_chat_type_message').attr('data-sid');
        var rid = $('.jp_chat_type_message').attr('data-rid');
       
        $.ajax({
            url  :  base_url+'chat/show_messages',
            data : { 'msg_id' : msg_id, 'sid' : sid, 'rid' : rid},
            type : 'post',
            success : function(result){
                var results = jQuery.parseJSON(result); 
                if(results.status){
                    if(results.html!=''){
                        $('.jp_chat_user_typing').text('Typing.....');
                        setTimeout(function(){
                            $('.jp_chat_content').prepend(results.html);
                            $('.jp_chat_user_typing').text('');
                        },2000);
                    }
                }
            }
        });	
        
    }
    var headerChat = '';
    if($('.chatCountHeader').length){
        headerChat = setInterval(function(){
            $.ajax({
                url  :  base_url+'chat/message_count',
                type : 'post',
                data : {'type':'header'},
                success : function(result){
                    var results = jQuery.parseJSON(result); 
                    if(results.status){
                        $('.chatCountHeader').text(results.count).css('display','inline-block');;
                    }else{
                        $('.chatCountHeader').text('').css('display','none');;
                    }
                }
            });	
        },3000);
    }else{
        clearInterval(headerChat);
    }

    var chatCount = '';
    if($('.jp_openChatBtnWrapper').length){
        $('.jp_openChatBtnWrapper').each(function(){
            var uid = $(this).attr('data-uid');
            var _this = $(this);
            chatCount = setInterval(function(){ 
                $.ajax({
                    url  :  base_url+'chat/message_count/'+uid,
                    type : 'post',
                    data : {'type':'inpage'},
                    success : function(result){
                        var results = jQuery.parseJSON(result); 
                        if(results.status){
                            _this.find('.jp_chat_count').text(results.count).css('display','inline-block');
                        }else{
                            _this.find('.jp_chat_count').text('').css('display','none');
                        }
                    }
                });	
            },2000);
        });
        
    }else{
        clearInterval(chatCount);
    }

  

});

function handleOnScroll(){
    var base_url = $('#chatbase_url').val();
    if($('.jp_chat_content').scrollTop() == 0){
        var sid = $('.jp_chat_type_message').attr('data-sid');
        var rid = $('.jp_chat_type_message').attr('data-rid');
        var limit = $('.jp_chat_content').attr('data-limit');
        $.ajax({
            url  :  base_url+'chat/getpreviouschat',
            data : { 'user_to' : rid, 'user_from' : sid , 'limit':limit},
            type : 'post',
            success : function(result){
                var results = jQuery.parseJSON(result); 
                if(results.status){
                    $('.jp_chat_content').append(results.html).attr('data-limit',parseInt(limit)+parseInt(8));
                }
            }
        });	
    }
}
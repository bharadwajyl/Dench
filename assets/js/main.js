//Global variables
var serialize;

//Custom placeholder for [input:date]
$(function() {
    $('.dob').attr('type', 'text');
    $('.dob').on('focus', function() {
        $(this).attr('type', 'date');
    });
    $('.dob').on('blur', function() {
        if(!$(this).val()) {
            $(this).attr('type', 'text');
        }
    });
});


//Function call
function Perform(type){
    if (type == "close"){
        $('#Register_form').find('input').val('');
        window.location.href="#";
    } else{
        if (type == 0){
            serialize = "&FormType=logout";
        } else {
            serialize = $("#"+type+"_form").serialize()+"&FormType="+type;
            $('#' + type + "_btn").text('Processing...').animate({'opacity': 1}, 400);
        }
        $.ajax({
            type:'POST',
            url:'php/',
            data:serialize,
            success:function(message){
                if (message.match(/successfull/gi)){
                    setTimeout(function(){Perform("close");}, 2000);
                    $('#' + type + "_btn").text(type).animate({'opacity': 1}, 400);
                } 
                if (message.match(/logged/gi)){
                    setTimeout(function(){location.reload();}, 2000);
                }
                popup(message);
            }
        });  
    }
}


//Popup messages
function popup(message){
    var popup = document.createElement("div");
    popup.setAttribute("id","popup");
    popup.setAttribute("class","show");
    popup.innerHTML = message;
    document.body.appendChild(popup);
    setTimeout(function(){
            popup.className = popup.className.replace("show", "");
            popup.remove();
            }, 4000);
    return 1;
}

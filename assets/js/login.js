//Function call
function Perform(type){
    if (type == "close"){
        $('#reg_form').find('input').val('');
        window.location.href="#";
    } else{
        $('#' + type + "_btn").text('Processing...').animate({'opacity': 1}, 400);;
        $.ajax({
            url:'php',
            type:'POST',
            data:$("#"+type+"_form").serialize()+"&FormType="+type,
            success:function(message){
                $('#' + type + "_btn").text(type).animate({'opacity': 1}, 400);;
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

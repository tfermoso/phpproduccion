$("#cart").click(function(){
    if($("#user").html()==""){
        //Hay que logearse
        $("#modal-login").modal("show");
    }
}

);
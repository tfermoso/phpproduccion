$("#cart").click(function(e){
    
    if($("#user").html()==""){
        e.preventDefault();
        //Hay que logearse
        $("#modal-login").modal("show");
    }
}

);
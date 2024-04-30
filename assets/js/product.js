$("#cart").click(function(e){
    
    if($("#user").html()==""){
        e.preventDefault();
        //Hay que logearse
        $("#modal-login").modal("show");
    }
}

);

$(".quantity").change((e)=>{
    let quantity=e.currentTarget.value;
    
});

$(".delete").click((e)=>{
    let idcartdetail=e.currentTarget.id;
    let url="delete_cart_detail.php?idcartdetail="+idcartdetail;
    fetch(url)
    .then(response => response.json())
    .then(data => {
      console.log(data); // Aquí recibes los datos en formato JSON
      // Puedes manipular los datos aquí
    })
    .catch(error => {
      console.error('Error:', error);
    });
   
})
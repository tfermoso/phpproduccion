$("#cart").click(function (e) {

  if ($("#user").html() == "") {
    e.preventDefault();
    //Hay que logearse
    $("#modal-login").modal("show");
  }
}

);

$(".quantity").change((e) => {
  let quantity = e.currentTarget.value;
  let idcartdetail = (e.currentTarget.parentElement.parentElement.id).replace("idcartdetail", "");
  let url = "update_cart_detail.php?idcartdetail=" + idcartdetail+"&quantity="+quantity;
  fetch(url)
    .then(response => response.json())
    .then(data => {
      //console.log(data); // Aquí recibes los datos en formato JSON
      // Puedes manipular los datos aquí
      let cart = data.cart;
      // Utilizamos map() para crear un nuevo array con los totales de cada producto
      var totalesPorProducto = cart.map(function (producto) {
        return producto.price * producto.quantity;
      });
      // Sumamos todos los totales de los productos utilizando reduce()
      var totalCart = totalesPorProducto.reduce(function (acumulador, total) {
        return acumulador + total;
      }, 0);
      $("#euros_total").html(totalCart+" €");
      //Actualizamos línea
      cart.forEach(p => {
        if(p.idcartdetail==idcartdetail){
          let total=p.quantity*p.price;
          let selector="#idcartdetail"+idcartdetail+ " td:eq(4)";
          $(selector).html(total+" €");
          
        }
      });
      console.log(cart)
    })
    .catch(error => {
      console.error('Error:', error);
    });

});

$(".delete").click((e) => {
  let fila = e.currentTarget.parentElement.parentElement;
  let idcartdetail = (e.currentTarget.parentElement.parentElement.id).replace("idcartdetail", "");
  let url = "delete_cart_detail.php?idcartdetail=" + idcartdetail;
  fetch(url)
    .then(response => response.json())
    .then(data => {
      //console.log(data); // Aquí recibes los datos en formato JSON
      // Puedes manipular los datos aquí
      fila.remove();
      let cart = data.cart;
      // Utilizamos map() para crear un nuevo array con los totales de cada producto
      var totalesPorProducto = cart.map(function (producto) {
        return producto.price * producto.quantity;
      });

      // Sumamos todos los totales de los productos utilizando reduce()
      var totalCart = totalesPorProducto.reduce(function (acumulador, total) {
        return acumulador + total;
      }, 0);
      $("#euros_total").html(totalCart+" €");
      $("#products_count").html(cart.length);
    })
    .catch(error => {
      console.error('Error:', error);
    });

})
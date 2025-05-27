function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
  

const btnWhatsapp = document.getElementById("btn-whatsapp-modal");

  // btnWhatsapp.addEventListener('click', () => {
  //   const producto = modalTitulo.innerText;
  //   const mensaje = `Hola, estoy interesad@ en el producto: ${producto}`;
  //   const numero = "573001234567"; // Reemplaza con tu número incluyendo el código de país
  //   const url = `https://wa.me/${numero}?text=${encodeURIComponent(mensaje)}`;
  //   window.open(url, '_blank');
  // });


// const solicitarBtn = document.getElementById("btn-whatsapp-modal");

// solicitarBtn.addEventListener("click", () => {
//   // Cambia a estado de carga
//   solicitarBtn.classList.add("loading");
//   solicitarBtn.innerHTML = "<span>Cargando...</span>";

//   // Después de que termina la animación (~2s)
//   setTimeout(() => {
//     solicitarBtn.innerHTML = "<span>Solicitud enviada ✅</span>";
//   }, 2000);

//   // Redirige luego de 3s total
//   setTimeout(() => {
//     const nombreProducto = document.getElementById("modal-titulo").innerText;
//     // const url = `https://wa.me/1234567890?text=Hola, estoy interesada en el producto: ${encodeURIComponent(nombreProducto)}`;
//     window.open(url, "_blank");
//   }, 3000);
// });

<?php include '../header.php'; ?>
<style>
#sugerencias {
  position: absolute;
  z-index: 1000;
  background-color: #696cffd1;
  width: 90%;
  max-height: 600px;
  overflow-x: auto;
  border: 1px solid #ccc;
  border-top: none;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  font-size: 14px;
  border-radius: 0 0 8px 8px;
  color: #fff;
}

#sugerencias{
  padding: 10px;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
}

#sugerencias:hover {
  background-color:#787bff;
  font-weight: 500;
  color: #333;
}
</style>

<div class="container mt-5">
  <h2>Crear Presupuesto</h2>
  <form action="guardar_presupuesto.php" method="POST">
    <div class="mb-3">
      <button type="button" class="btn btn-outline-primary" id="btn-nuevo-cliente">+ Cliente nuevo</button>
    </div>

    <div id="cliente-existente">
      <div class="mb-3">
          <label for="cliente" class="form-label">Cliente</label>
          <input type="text" id="cliente" name="cliente" class="form-control" autocomplete="off" required>
          <input type="hidden" id="cliente_id" name="cliente_id">
          <div id="sugerencias" class="list-group mt-1"></div>
      </div>
    </div>
    
    <!-- Mini formulario para nuevo cliente (inicialmente oculto) -->
    <div id="nuevo-cliente-form" class="border rounded p-3 mb-3" style="display: none;">
      <h6>Nuevo Cliente</h6>
      <div class="mb-2">
        <label for="nuevo_nombre" class="form-label">Nombre</label>
        <input type="text" id="nuevo_nombre" name="nuevo_nombre" class="form-control">
      </div>
      <div class="mb-2">
        <label for="nuevo_telefono" class="form-label">Teléfono</label>
        <input type="text" id="nuevo_telefono" name="nuevo_telefono" class="form-control">
      </div>
      <div class="mb-2">
        <label for="nuevo_correo" class="form-label">Correo</label>
        <input type="email" id="nuevo_correo" name="nuevo_correo" class="form-control">
      </div>
      <div class="mb-2">
        <label for="nuevo_direccion" class="form-label">Dirección</label>
        <input type="text" id="nuevo_direccion" name="nuevo_direccion" class="form-control">
      </div>
    </div>

    <!-- Otros datos del presupuesto -->
    <div class="mb-3 mt-5">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" id="fecha" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>
    <hr>
    <h5>Productos</h5>
    <table class="table table-bordered" id="tabla-productos">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Subtotal</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="productos-container">
        <tr>
          <td><input type="text" name="producto_nombre[]" class="form-control producto-input" placeholder="Buscar producto..." autocomplete="off"></td>
          <input type="hidden" name="producto_id[]" class="producto-id">
          <td><input type="number" name="cantidad[]" class="form-control cantidad-input" min="1" value="1"></td>
          <td><input type="number" name="precio[]" class="form-control precio-input" step="0.01" min="0"></td>
          <td><input type="text" class="form-control subtotal" readonly></td>
          <td><button type="button" class="btn btn-danger btn-sm eliminar-producto">X</button></td>
        </tr>
      </tbody>
    </table>
    <button type="button" class="btn btn-secondary" id="agregar-producto">+ Añadir producto</button>

    <hr>
    <h4>Total: $<span id="total-general">0.00</span></h4>

    <input type="hidden" name="total" id="total-hidden" value="0">

    <!-- Botón -->
    <button type="submit" class="btn btn-primary">Crear Presupuesto</button>
  </form>
</div>

<script>
  document.getElementById('cliente').addEventListener('input', function () {
    const query = this.value;

    if (query.length >= 2) {
      fetch('buscar_clientes.php?q=' + encodeURIComponent(query))
      .then(response => response.json())
      .then(data => {
        const sugerencias = document.getElementById('sugerencias');
        sugerencias.innerHTML = '';
        data.forEach(cliente => {
          const item = document.createElement('a');
          item.classList.add('list-group-item', 'list-group-item-action');
          item.textContent = cliente.nombre + ' (' + cliente.correo + ')';
          item.onclick = function () {
            document.getElementById('cliente').value = cliente.nombre;
            document.getElementById('cliente_id').value = cliente.id;
            sugerencias.innerHTML = '';
          };
          sugerencias.appendChild(item);
        });
      });
    }
  });

</script>

<script>
  function calcularSubtotal(row) {
    const cantidad = parseFloat(row.querySelector('.cantidad-input').value) || 0;
    const precio = parseFloat(row.querySelector('.precio-input').value) || 0;
    const subtotal = cantidad * precio;
    row.querySelector('.subtotal').value = subtotal.toFixed(2);
    calcularTotalGeneral();
  }

  function calcularTotalGeneral() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(function(input) {
      total += parseFloat(input.value) || 0;
    });
    document.getElementById('total-general').innerText = total.toFixed(2);
    document.getElementById('total-hidden').value = total.toFixed(2);
  }

  document.getElementById('productos-container').addEventListener('input', function(e) {
    const row = e.target.closest('tr');
    calcularSubtotal(row);
  });

  document.getElementById('productos-container').addEventListener('click', function(e) {
    if (e.target.classList.contains('eliminar-producto')) {
      e.target.closest('tr').remove();
      calcularTotalGeneral();
    }
  });

  document.getElementById('agregar-producto').addEventListener('click', function() {
    const row = document.querySelector('#productos-container tr').cloneNode(true);
    row.querySelectorAll('input').forEach(input => input.value = '');
    document.getElementById('productos-container').appendChild(row);
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("input", function (e) {
    if (e.target.classList.contains("producto-input")) {
      const input = e.target;
      const value = input.value.trim();
      const sugerenciasDiv = document.createElement("div");
      sugerenciasDiv.className = "sugerencias-producto";
      sugerenciasDiv.style.position = "absolute";
      sugerenciasDiv.style.zIndex = "1000";
      sugerenciasDiv.style.background = "#fff";
      sugerenciasDiv.style.border = "1px solid #ccc";
      sugerenciasDiv.style.width = input.offsetWidth + "px";
      sugerenciasDiv.style.maxHeight = "200px";
      sugerenciasDiv.style.overflowY = "auto";
      sugerenciasDiv.style.boxShadow = "0 4px 8px rgba(0,0,0,0.1)";
      
      // Elimina cualquier sugerencia anterior
      document.querySelectorAll(".sugerencias-producto").forEach(el => el.remove());

      if (value.length > 1) {
        fetch("buscar_productos.php?term=" + encodeURIComponent(value))
          .then(res => res.json())
          .then(data => {
            if (data.length > 0) {
              data.forEach(producto => {
                const item = document.createElement("div");
                if (producto.stock > 0) {
                item.textContent = producto.nombre + " ($" + producto.precio + ")";
                item.style.padding = "8px";
                item.style.cursor = "pointer";
                item.addEventListener("click", function () {
                  input.value = producto.nombre;
                  input.closest("tr").querySelector(".producto-id").value = producto.id;
                  input.closest("tr").querySelector(".precio-input").value = producto.precio;
                  document.querySelectorAll(".sugerencias-producto").forEach(el => el.remove());
                });
              }else{
                item.textContent = producto.nombre + " (Sin stock)";
                item.style.color = "#999";
                item.style.cursor = "not-allowed";
                item.style.padding = "8px";
              }
                sugerenciasDiv.appendChild(item);
              });

              input.parentNode.appendChild(sugerenciasDiv);
            }
          });
      }
    }
  });

  // Ocultar sugerencias si se hace clic fuera
  document.addEventListener("click", function (e) {
    if (!e.target.classList.contains("producto-input")) {
      document.querySelectorAll(".sugerencias-producto").forEach(el => el.remove());
    }
  });
});
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const btnNuevoCliente = document.getElementById("btn-nuevo-cliente");
    const formNuevoCliente = document.getElementById("nuevo-cliente-form");
    const divClienteExistente = document.getElementById("cliente-existente");

    let usandoClienteNuevo = false;


    btnNuevoCliente.addEventListener("click", function () {
      usandoClienteNuevo = !usandoClienteNuevo;      
      if (usandoClienteNuevo) {
        formNuevoCliente.style.display = "block";
        divClienteExistente.style.display = "none";
        btnNuevoCliente.textContent = "← Volver a clientes registrados";
      } else {
        formNuevoCliente.style.display = "none";
        divClienteExistente.style.display = "block";
        btnNuevoCliente.textContent = "+ Cliente nuevo";
      }

      //formNuevoCliente.style.display = formNuevoCliente.style.display === "none" ? "block" : "none";
    });
  });
</script>


<?php include '../footer.php'; ?>
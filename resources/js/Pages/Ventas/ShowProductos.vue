<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Productos de la Venta #{{ venta.id }}</h1>
      <p>Cliente: {{ venta.cliente.nombre }}</p>
      <p>Fecha de Venta: {{ venta.fecha }}</p>
      <p>Total: ${{ venta.total_compra }}</p>
  
      <h2 class="text-xl font-bold mt-4 mb-2">Productos</h2>
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="producto in productos" :key="producto.id">
            <td>{{ producto.nombre }}</td>
            <td>{{ producto.pivot.cantidad }}</td>
            <td>${{ producto.pivot.precio_unitario }}</td>
            <td>${{ producto.pivot.cantidad * producto.pivot.precio_unitario }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      venta: Object,
      productos: Array,
    },
  };
  </script>
  
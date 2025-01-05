<template>
    <div>
      <h1>Productos de la Venta</h1>
      <div>
        <p>Venta ID: {{ venta.id }}</p>
        <p>Cliente: {{ venta.cliente }}</p>
      </div>
  
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="producto in venta.productos" :key="producto.id">
            <td>{{ producto.nombre }}</td>
            <td>{{ producto.cantidad }}</td>
            <td>{{ producto.precio_unitario }}</td>
            <td>{{ producto.total }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      venta: Object,
    },
  }
  </script>
  
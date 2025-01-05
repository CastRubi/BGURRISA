<template>
    <div>
      <h1>Lista de Abonos</h1>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Venta</th>
            <th>Monto Abonado</th>
            <th>Fecha Abono</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="abono in abonos" :key="abono.id">
            <td>{{ abono.id }}</td>
            <td>{{ abono.venta_id }}</td>
            <td>{{ abono.monto_abono }}</td>
            <td>{{ abono.fecha_abono }}</td>
          </tr>
        </tbody>
      </table>
      <inertia-link href="/abonos/create">Realizar un nuevo abono</inertia-link>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      abonos: Array
    }
  }
  </script>
  
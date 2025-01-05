<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Abonos para la Venta #{{ venta.id }}</h1>
    <p>Cliente: {{ venta.cliente.nombre }}</p>
    <p>Fecha de Venta: {{ venta.fecha }}</p>
    <p>Total: ${{ venta.total_compra }}</p>
    <p>Saldo Pendiente: ${{ saldoPendiente }}</p>

    <h2 class="text-xl font-bold mt-4 mb-2">Historial de Abonos</h2>
    <table class="table-auto w-full">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Monto</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="abono in abonos" :key="abono.id">
          <td>{{ abono.fecha }}</td>
          <td>${{ abono.monto }}</td>
        </tr>
      </tbody>
    </table>

    <Link :href="`/ventas/${venta.id}/abonos/create`" class="btn btn-primary mt-4">Agregar Abono</Link>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
  props: {
    venta: Object,
    abonos: Array,
    saldoPendiente: Number,
  },
};
</script>

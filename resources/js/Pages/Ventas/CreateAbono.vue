<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Nuevo Abono para la Venta #{{ venta.id }}</h1>
      <p>Cliente: {{ venta.cliente.nombre }}</p>
      <p>Total: ${{ venta.total_compra }}</p>
      <p>Saldo Pendiente: ${{ saldoPendiente }}</p>
  
      <form @submit.prevent="submit">
        <div>
          <label>Monto del Abono</label>
          <input v-model="form.monto" type="number" required />
        </div>
        <div>
          <label>Fecha</label>
          <input v-model="form.fecha" type="date" required />
        </div>
        <button type="submit" class="btn btn-primary mt-4">Registrar Abono</button>
      </form>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
  
  export default {
    props: {
      venta: Object,
      saldoPendiente: Number,
    },
    data() {
      return {
        form: {
          monto: '',
          fecha: new Date().toISOString().split('T')[0], // Fecha actual
        },
      };
    },
    methods: {
      submit() {
        Inertia.post(`/ventas/${this.venta.id}/abonos`, this.form);
      },
    },
  };
  </script>
  
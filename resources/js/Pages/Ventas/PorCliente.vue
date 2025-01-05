<template>
    <Layout title="Ventas por Cliente">
      <div class="p-10 sm:ml-64">
        <div class="mb-12 mt-2 text-center">
          <h2 class="text-4xl font-bold text-black inline-block">Ventas por Cliente</h2>
          <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
        </div>
  
        <div class="bg-green-500 bg-opacity-50 p-4 rounded shadow-md">
          <h3 class="text-xl font-bold text-center text-black">Selecciona un Cliente</h3>
  
          <div class="mt-6">
            <label for="cliente" class="block text-black font-semibold">Cliente</label>
            <select
              id="cliente"
              v-model="selectedClienteId"
              class="p-2 rounded w-full mt-2"
              @change="cargarVentasDelCliente"
            >
              <option disabled value="">Seleccione un cliente</option>
              <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                {{ cliente.nombre }}
              </option>
            </select>
          </div>
        </div>
  
        <!-- Información del cliente y sus ventas -->
        <div v-if="clienteSeleccionado" class="mt-8 p-6 bg-gray-100 rounded shadow-md">
          <h3 class="text-2xl font-bold text-black">Información del Cliente</h3>
          <p><strong>Nombre:</strong> {{ clienteSeleccionado.nombre }}</p>
          <p><strong>Email:</strong> {{ clienteSeleccionado.email }}</p>
          <p><strong>Teléfono:</strong> {{ clienteSeleccionado.telefono }}</p>
  
          <h4 class="text-xl font-bold text-black mt-4">Ventas Asociadas</h4>
          <ul v-if="ventas.length">
            <li v-for="venta in ventas" :key="venta.id" class="mt-2">
              <strong>Venta ID:</strong> {{ venta.id }},
              <strong>Fecha:</strong> {{ venta.fecha }},
              <strong>Total:</strong> {{ venta.total }}
            </li>
          </ul>
          <p v-else class="text-red-500">No hay ventas asociadas para este cliente.</p>
        </div>
      </div>
    </Layout>
  </template>
  
  <script>
  import Layout from "@/Layouts/Layout.vue";
  import { Inertia } from "@inertiajs/inertia";
  
  export default {
    components: { Layout },
    props: {
      clientes: Array, // Lista de clientes pasada desde el backend
    },
    data() {
      return {
        selectedClienteId: "", // ID del cliente seleccionado
        clienteSeleccionado: null, // Información del cliente seleccionado
        ventas: [], // Ventas asociadas al cliente seleccionado
      };
    },
    methods: {
      async cargarVentasDelCliente() {
        if (this.selectedClienteId) {
          try {
            // Solicitud para cargar las ventas del cliente
            const response = await axios.get(`/api/clientes/${this.selectedClienteId}/ventas`);
            this.clienteSeleccionado = response.data.cliente;
            this.ventas = response.data.ventas;
          } catch (error) {
            console.error("Error al cargar las ventas del cliente:", error);
          }
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar estilos personalizados aquí */
  </style>
  
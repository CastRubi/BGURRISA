<template>
    <Layout>
      <div class="p-10 sm:ml-64">
        <div class="mb-12 mt-2 text-center">
          <h2 class="text-4xl font-bold text-black inline-block">
            Protegiendo cada cosecha con calidad y confianza
          </h2>
          <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
        </div>
  
        <!-- Botón para crear una nueva venta -->
        <div class="mb-4">
          <button
            @click="crearVenta"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
          >
            Crear Venta
          </button>
        </div>
  
        <!-- Selección de cliente -->
        <div class="flex justify-between items-center mb-4">
          <div v-if="!selectedCliente" class="bg-green-500 bg-opacity-50 p-4 rounded shadow-md w-full mr-4">
            <label for="cliente-select" class="block text-center text-lg font-semibold text-black">
              Selecciona un Cliente
            </label>
            <select
              id="cliente-select"
              v-model="selectedCliente"
              @change="fetchVentas"
              class="w-full border rounded p-2"
            >
              <option disabled value="">-- Escoge un cliente --</option>
              <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                {{ cliente.id }} - {{ cliente.nombre }}
              </option>
            </select>
          </div>
        </div>
  
        <!-- Mostrar cliente seleccionado -->
        <div v-if="selectedCliente !== ''" class="mb-4">
          <p class="text-gray-700"><strong>Cliente Seleccionado:</strong> {{ selectedClienteNombre }}</p>
        </div>
  
        <!-- Tabla de ventas -->
        <div class="overflow-x-auto bg-green-500 bg-opacity-50 p-4 rounded shadow-md mt-4">
          <h3 class="text-xl font-bold text-center text-black">Datos de Ventas</h3>
          <table v-if="ventas.length > 0" class="min-w-full mt-4">
            <thead class="bg-gray-50">
              <tr>
                <th>Venta ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total Compra</th>
                <th>Abonos</th>
                <th>Saldo</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="venta in ventas" :key="venta.id">
                <td>{{ venta.id }}</td>
                <td>{{ venta.cliente.nombre }}</td>
                <td>{{ venta.fecha }}</td>
                <td>{{ venta.total_compra }}</td>
                <td>{{ venta.abonos }}</td>
                <td>{{ venta.saldo }}</td>
                <td class="flex gap-2">
                  <button @click="verProductos(venta.id)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">Ver Productos</button>
                  <button @click="mostrarFormularioAbono(venta.id)" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-1 px-3 rounded">Abonar</button>
                </td>
              </tr>
            </tbody>
          </table>
          <p v-else class="text-center text-gray-500 mt-4">No hay ventas para mostrar.</p>
        </div>
  
        <!-- Formulario de abono -->
        <div v-if="abonoFormVisible" class="bg-yellow-100 p-6 rounded shadow-md mt-8">
          <h3 class="text-xl font-bold text-center text-black">Realizar Abono</h3>
          <form @submit.prevent="realizarAbono">
            <div class="mb-4">
              <label for="monto-abono">Monto de Abono</label>
              <input
                id="monto-abono"
                v-model="montoAbono"
                type="number"
                step="0.01"
                required
              />
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Realizar Abono</button>
          </form>
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
      clientes: Array,
      ventas: Array,
    },
    data() {
      return {
        selectedCliente: "",
        productos: [],
        abonoFormVisible: false,
        montoAbono: 0,
        ventaIdAbono: null,
      };
    },
    computed: {
      selectedClienteNombre() {
        const cliente = this.clientes.find(cliente => cliente.id == this.selectedCliente);
        return cliente ? cliente.nombre : '';
      },
    },
    methods: {
      fetchVentas() {
        Inertia.get(`/ventas?cliente_id=${this.selectedCliente}`, { preserveState: true });
      },
      mostrarFormularioAbono(ventaId) {
        this.ventaIdAbono = ventaId;
        this.abonoFormVisible = true;
      },
      realizarAbono() {
        Inertia.post(`/ventas/${this.ventaIdAbono}/abonos`, {
          monto_abono: this.montoAbono,
        }, {
          onSuccess: () => {
            this.abonoFormVisible = false;
            this.montoAbono = 0;
            this.fetchVentas();
          },
        });
      },
      crearVenta() {
        Inertia.get('/ventas/create'); // Redirige a la vista de creación de ventas
      },
    },
  };
  </script>
  
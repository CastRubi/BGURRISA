<template>
  <Layout>
    <div class="p-10 sm:ml-64">
      <!-- Encabezado -->
      <div class="mb-12 mt-2 text-center">
        <h2 class="text-4xl font-bold text-black inline-block">
          Protegiendo cada cosecha con calidad y confianza
        </h2>
        <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
      </div>

      <h1 class="text-3xl font-bold text-center text-gray-700 mb-6">
        Lista de Proveedores
      </h1>

      <!-- Botón para agregar proveedor -->
      <div class="flex justify-end mb-4">
        <button
          @click="irCrearProveedor"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
        >
          + Agregar Proveedor
        </button>
      </div>

      <!-- Tabla de proveedores -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2 text-left text-gray-600">ID</th>
              <th class="px-4 py-2 text-left text-gray-600">Nombre</th>
              <th class="px-4 py-2 text-left text-gray-600">Teléfono</th>
              <th class="px-4 py-2 text-left text-gray-600">Correo</th>
              <th class="px-4 py-2 text-left text-gray-600">Fecha de Compra</th>
              <th class="px-4 py-2 text-left text-gray-600">Marca</th>
              <th class="px-4 py-2 text-left text-gray-600">Cantidad</th>
              <th class="px-4 py-2 text-left text-gray-600">Precio</th>
              <th class="px-4 py-2 text-left text-gray-600">Importe</th>
              <th class="px-4 py-2 text-left text-gray-600">Abono</th>
              <th class="px-4 py-2 text-left text-gray-600">Saldo</th>
              <th class="px-4 py-2 text-left text-gray-600">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="proveedor in proveedores"
              :key="proveedor.id"
              class="hover:bg-gray-50 transition-colors"
            >
              <td class="px-4 py-2 border">{{ proveedor.id }}</td>
              <td class="px-4 py-2 border">{{ proveedor.nombre }}</td>
              <td class="px-4 py-2 border">{{ proveedor.telefono }}</td>
              <td class="px-4 py-2 border">{{ proveedor.correo }}</td>
              <td class="px-4 py-2 border">{{ proveedor.fecha_compra }}</td>
              <td class="px-4 py-2 border">{{ proveedor.marca }}</td>
              <td class="px-4 py-2 border">{{ proveedor.cantidad_producto }}</td>
              <td class="px-4 py-2 border">{{ proveedor.precio }}</td>
              <td class="px-4 py-2 border">{{ proveedor.importe }}</td>
              <td class="px-4 py-2 border">{{ proveedor.abono }}</td>
              <td class="px-4 py-2 border">{{ proveedor.saldo }}</td>
              <td class="px-4 py-2 border flex space-x-2">
                <button
                  @click="abrirModalAbono(proveedor)"
                  class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded"
                >
                  Abonar
                </button>
                <button
                  @click="verAbonos(proveedor.id)"
                  class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded"
                >
                  Detalles
                </button>
                <button
                  @click="abrirModalEliminarProveedor(proveedor)"
                  class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded"
                >
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal de Abono -->
      <div
        v-if="mostrarModalAbono"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
      >
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-xl font-bold mb-4">Abonar al proveedor</h2>
          <p class="mb-4">Proveedor: {{ proveedorSeleccionado?.nombre }}</p>
          <input
            v-model="montoAbono"
            type="number"
            placeholder="Monto a abonar"
            class="border border-gray-300 rounded p-2 w-full mb-4"
          />
          <div class="flex justify-end space-x-2">
            <button
              @click="abonar"
              class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
            >
              Confirmar
            </button>
            <button
              @click="cerrarModal"
              class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
            >
              Cancelar
            </button>
          </div>
        </div>
      </div>

      <!-- Modal de Eliminar -->
      <div
        v-if="mostrarModalEliminar"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
      >
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-xl font-bold mb-4 text-red-600">Eliminar Proveedor</h2>
          <p>¿Estás seguro de eliminar al proveedor <strong>{{ proveedorSeleccionado?.nombre }}</strong>?</p>
          <div class="flex justify-end space-x-2 mt-4">
            <button
              @click="eliminarProveedor"
              class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
            >
              Eliminar
            </button>
            <button
              @click="cerrarModal"
              class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
            >
              Cancelar
            </button>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Layout from "@/Layouts/Layout.vue";

export default {
  components: { Layout },
  props: {
    proveedores: Array,
  },
  setup() {
    const mostrarModalAbono = ref(false);
    const mostrarModalEliminar = ref(false);
    const proveedorSeleccionado = ref(null);
    const montoAbono = ref("");

    const irCrearProveedor = () => {
      Inertia.get("/proveedores/create");
    };

    const abrirModalAbono = (proveedor) => {
      proveedorSeleccionado.value = proveedor;
      montoAbono.value = "";
      mostrarModalAbono.value = true;
    };

    const abrirModalEliminarProveedor = (proveedor) => {
      proveedorSeleccionado.value = proveedor;
      mostrarModalEliminar.value = true;
    };

    const abonar = () => {
      if (montoAbono.value) {
        Inertia.post(`/proveedores/${proveedorSeleccionado.value.id}/abonar`, {
          monto_abonado: montoAbono.value,
        });
        cerrarModal();
      }
    };

    const eliminarProveedor = () => {
      Inertia.delete(`/proveedores/${proveedorSeleccionado.value.id}`);
      cerrarModal();
    };

    const cerrarModal = () => {
      mostrarModalAbono.value = false;
      mostrarModalEliminar.value = false;
      proveedorSeleccionado.value = null;
    };

    const verAbonos = (id) => {
      // Redirige al usuario a la página de detalles del proveedor
      Inertia.get(`/proveedores/${id}/detalles-abono`);
    };

    return {
      irCrearProveedor,
      abrirModalAbono,
      abrirModalEliminarProveedor,
      abonar,
      eliminarProveedor,
      cerrarModal,
      mostrarModalAbono,
      mostrarModalEliminar,
      proveedorSeleccionado,
      montoAbono,
      verAbonos,
    };
  },
};
</script>

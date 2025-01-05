<template>
  <Layout title="Productos">
    <div class="p-10 sm:ml-64">
      <div class="mb-12 mt-2 text-center">
        <h2 class="text-4xl font-bold text-black inline-block">
          Protegiendo cada cosecha con calidad y confianza
        </h2>
        <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
      </div>
      <div class="bg-green-500 bg-opacity-50 p-4 rounded shadow-md">
        <h3 class="text-xl font-bold text-center text-black">Datos de Productos</h3>
        <table class="min-w-full mt-4 table-auto mx-4">
          <thead>
            <tr>
              <th class="border text-black px-2 py-2 text-center">ID</th>
              <th class="border text-black px-2 py-2 text-center">Concepto</th>
              <th class="border text-black px-2 py-2 text-center">Precio</th>
              <th class="border text-black px-2 py-2 text-center">Cantidad Disponible</th>
              <th class="border text-black px-2 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="producto in productos" :key="producto.id">
              <td class="border px-2 py-2 text-center">{{ producto.id }}</td>
              <td class="border px-2 py-2 text-center">{{ producto.concepto }}</td>
              <td class="border px-2 py-2 text-center">{{ producto.precio }}</td>
              <td class="border px-2 py-2 text-center">{{ producto.cantidad_disponible }}</td>
              <td class="border px-2 py-2 text-center flex justify-center items-center gap-2">
                <button
                  @click="editarProducto(producto)"
                  class="bg-yellow-500 text-white px-2 py-1 rounded"
                >
                  Editar
                </button>
                <button
                  @click="abrirModalEliminarProducto(producto)"
                  class="bg-red-500 text-white px-2 py-1 rounded"
                >
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Botones abajo -->
      <div class="mt-4 text-center flex justify-center gap-4">
        <button
          @click="agregarProducto"
          class="bg-blue-500 text-white px-4 py-2 rounded"
        >
          Agregar Producto
        </button>
        <button
          @click="verDetallesMovimiento"
          class="bg-green-500 text-white px-4 py-2 rounded"
        >
          Detalles
        </button>
      </div>

      <!-- Modal de confirmación para eliminar producto -->
      <div v-if="modalVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
          <h3 class="text-xl font-bold text-center">Confirmar Eliminación</h3>
          <p class="text-center mt-4">¿Estás seguro de que deseas eliminar el producto <span class="font-bold">{{ productoAEliminar?.concepto }}</span>?</p>
          <div class="mt-6 flex justify-center gap-4">
            <button
              @click="confirmarEliminacion"
              class="bg-red-500 text-white px-4 py-2 rounded"
            >
              Sí, Eliminar
            </button>
            <button
              @click="cerrarModal"
              class="bg-gray-500 text-white px-4 py-2 rounded"
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
import Layout from "@/Layouts/Layout.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: { Layout },
  props: {
    productos: Array,
  },
  setup(props) {
    const productos = ref(props.productos);
    const modalVisible = ref(false);
    const productoAEliminar = ref(null);

    const editarProducto = (producto) => {
      // Redirige a la vista de edición con el producto seleccionado
      Inertia.visit(`/productos/${producto.id}/edit`);
    };

    const agregarProducto = () => {
      Inertia.visit("/productos/create"); // Redirige a la página para crear un producto
    };

    const abrirModalEliminarProducto = (producto) => {
      productoAEliminar.value = producto;
      modalVisible.value = true;
    };

    const cerrarModal = () => {
      modalVisible.value = false;
      productoAEliminar.value = null;
    };

    const confirmarEliminacion = () => {
      if (productoAEliminar.value) {
        Inertia.delete(`/productos/${productoAEliminar.value.id}`); // Envia la solicitud DELETE para eliminar el producto
      }
      cerrarModal(); // Cierra el modal
    };

    const verDetallesMovimiento = () => {
      // Redirige a la página de movimientos de inventario
      Inertia.visit('/movimiento-inventario');
    };

    return {
      productos,
      editarProducto,
      agregarProducto,
      abrirModalEliminarProducto,
      cerrarModal,
      confirmarEliminacion,
      modalVisible,
      productoAEliminar,
      verDetallesMovimiento,
    };
  },
};
</script>

<style scoped>
/* Estilos adicionales */
</style>

<template>
  <Layout title="Editar Proveedor">
    <div class="p-10 sm:ml-64">
      <div class="mb-12 mt-2 text-center">
        <h2 class="text-4xl font-bold text-black inline-block">
          Editar Proveedor
        </h2>
        <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
      </div>

      <div class="bg-green-500 bg-opacity-50 p-4 rounded shadow-md">
        <h3 class="text-xl font-bold text-center text-black">Detalles del Proveedor</h3>

        <form @submit.prevent="submit">
          <div class="mt-4 grid grid-cols-1 gap-4">
            <div class="flex justify-between">
              <label class="text-black" for="fecha_compra">Fecha de Compra:</label>
              <input type="date" v-model="proveedor.fecha_compra" id="fecha_compra" class="p-2 rounded" required />
            </div>
            <div class="flex justify-between">
              <label class="text-black" for="cantidad_producto">Cantidad Producto:</label>
              <input type="number" v-model="proveedor.cantidad_producto" id="cantidad_producto" class="p-2 rounded" required />
            </div>
            <div class="flex justify-between">
              <label class="text-black" for="marca">Marca:</label>
              <input type="text" v-model="proveedor.marca" id="marca" class="p-2 rounded" required />
            </div>
            <div class="flex justify-between">
              <label class="text-black" for="precio">Precio:</label>
              <input type="number" v-model="proveedor.precio" id="precio" class="p-2 rounded" required />
            </div>
            <div class="flex justify-between">
              <label class="text-black" for="importe">Importe:</label>
              <input type="number" v-model="proveedor.importe" id="importe" class="p-2 rounded" required />
            </div>
          </div>

          <div class="mt-4 text-center">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
              Actualizar Proveedor
            </button>
          </div>
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
    proveedor: Object,
  },
  methods: {
    submit() {
      Inertia.put(`/proveedores/${this.proveedor.id_proveedor}`, this.proveedor, {
        onSuccess: () => {
          alert("Proveedor actualizado con éxito.");
        },
        onError: () => {
          alert("Hubo un error al actualizar el proveedor.");
        },
      });
    },
  },
};
</script>

<style scoped>
/* Estilos adicionales */
</style>

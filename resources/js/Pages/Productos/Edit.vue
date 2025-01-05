<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Layout from "@/Layouts/Layout.vue";

// Propiedades pasadas desde el backend
const props = defineProps({
  producto: Object,
});

// Estado para gestionar el formulario
const producto = ref(props.producto);

// Función para actualizar el producto
const actualizarProducto = async () => {
  Inertia.put(`/productos/${producto.value.id}`, producto.value, {
    onSuccess: () => {
      // Redirigir después de la actualización exitosa (opcional)
      Inertia.visit('/productos');
    },
    onError: (errors) => {
      // Aquí puedes manejar errores si es necesario
      console.error(errors);
    }
  });
};
</script>

<template>
  <Layout title="Editar Producto">
    <div class="p-10 sm:ml-64">
      <div class="mb-12 mt-2 text-center">
        <h2 class="text-4xl font-bold text-black inline-block">
          Protegiendo cada cosecha con calidad y confianza
        </h2>
        <hr class="my-5 border-gray-500" />
      </div>

      <div class="bg-green-500 bg-opacity-50 p-6 rounded-lg shadow-md max-w-xl mx-auto">
        <div class="mb-6 text-center">
          <h3 class="text-center text-2xl font-semibold text-black">Editar Producto</h3>
        </div>
        <form @submit.prevent="actualizarProducto">
          <!-- Concepto -->
          <div class="mb-4">
            <label for="concepto" class="block text-gray-700">Concepto</label>
            <input v-model="producto.concepto" id="concepto" type="text"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600"/>
          </div>

          <!-- Precio -->
          <div class="mb-4">
            <label for="precio" class="block text-gray-700">Precio</label>
            <input v-model="producto.precio" id="precio" type="number"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600"/>
          </div>

          <!-- Botón centrado -->
          <div class="flex justify-center">
            <button type="submit"
                    class="py-2 px-6 bg-indigo-600 text-white rounded-md shadow-md hover:bg-indigo-700 transition duration-200">
              Guardar Cambios
            </button>
          </div>
        </form>
      </div>
    </div>
  </Layout>
</template>

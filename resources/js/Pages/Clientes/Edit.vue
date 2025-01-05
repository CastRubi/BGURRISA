<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Layout from "@/Layouts/Layout.vue";

// Propiedades pasadas desde el backend
const props = defineProps({
  cliente: Object,
});

// Estado para gestionar el formulario
const cliente = ref(props.cliente);

// Función para actualizar el cliente
const actualizarCliente = async () => {
  Inertia.put(`/clientes/${cliente.value.id}`, cliente.value, {
    onSuccess: () => {
      // Redirigir después de la actualización exitosa (opcional)
      Inertia.visit('/clientes');
    },
    onError: (errors) => {
      // Aquí puedes manejar errores si es necesario
      console.error(errors);
    }
  });
};
</script>

<template>
  <Layout title="Editar Cliente">
    <div class="p-10 sm:ml-64">
      <div class="mb-12 mt-2 text-center">
        <h2 class="text-4xl font-bold text-black inline-block">
          Protegiendo cada cosecha con calidad y confianza
        </h2>
        <hr class="my-5 border-gray-500" />
      </div>

      <div class="bg-green-500 bg-opacity-50 p-6 rounded-lg shadow-md max-w-xl mx-auto">
        <div class="mb-6 text-center">
          <h3 class="text-center text-2xl font-semibold text-black">Editar Cliente</h3>
        </div>
        <form @submit.prevent="actualizarCliente">
          <div class="mb-4">
            <label for="nombre" class="block text-gray-700">Nombre Completo</label>
            <input v-model="cliente.nombre" id="nombre" type="text"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600"/>
          </div>

          <div class="mb-4">
            <label for="telefono" class="block text-gray-700">Teléfono</label>
            <input v-model="cliente.telefono" id="telefono" type="text"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600"/>
          </div>

          <div class="mb-4">
            <label for="email" class="block text-gray-700">Correo Electrónico</label>
            <input v-model="cliente.email" id="email" type="email"
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

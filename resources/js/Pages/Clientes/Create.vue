<template>
    <Layout>
      <div class="p-10 sm:ml-64">
        <div class="mb-12 mt-2 text-center">
          <h2 class="text-4xl font-bold text-black inline-block">
            Agregar Nuevo Cliente
          </h2>
          <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
        </div>
  
        <form @submit.prevent="guardarCliente" class="bg-white p-6 rounded-lg shadow-md">
          <!-- Nombre -->
          <div class="mb-4">
            <label for="nombre" class="block text-gray-700 font-semibold">Nombre del Cliente:</label>
            <input
              type="text"
              id="nombre"
              v-model="form.nombre"
              class="w-full mt-2 p-2 border rounded"
              placeholder="Ingrese el nombre del cliente"
            />
          </div>
  
          <!-- Teléfono -->
          <div class="mb-4">
            <label for="telefono" class="block text-gray-700 font-semibold">Teléfono:</label>
            <input
              type="text"
              id="telefono"
              v-model="form.telefono"
              class="w-full mt-2 p-2 border rounded"
              placeholder="Ingrese el teléfono"
            />
          </div>
  
          <!-- Correo -->
          <div class="mb-4">
            <label for="correo" class="block text-gray-700 font-semibold">Correo:</label>
            <input
              type="email"
              id="correo"
              v-model="form.correo"
              class="w-full mt-2 p-2 border rounded"
              placeholder="Ingrese el correo"
            />
          </div>
  
          <!-- Dirección -->
          <div class="mb-4">
            <label for="direccion" class="block text-gray-700 font-semibold">Dirección:</label>
            <input
              type="text"
              id="direccion"
              v-model="form.direccion"
              class="w-full mt-2 p-2 border rounded"
              placeholder="Ingrese la dirección del cliente"
            />
          </div>
  
          <!-- Botones -->
          <div class="flex justify-end space-x-4">
            <button
              type="button"
              @click="cancelar"
              class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
            >
              Cancelar
            </button>
            <button
              type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
            >
              Guardar
            </button>
          </div>
        </form>
      </div>
    </Layout>
  </template>
  
  <script>
  import { ref } from "vue";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@/Layouts/Layout.vue";
  
  export default {
    components: { Layout },
    setup() {
      const form = ref({
        nombre: "",
        telefono: "",
        correo: "",
        direccion: "",
      });
  
      const guardarCliente = () => {
        if (form.value.nombre && form.value.telefono && form.value.correo) {
          Inertia.post("/clientes", form.value);
        } else {
          alert("Por favor, completa todos los campos obligatorios.");
        }
      };
  
      const cancelar = () => {
        if (confirm("¿Deseas cancelar? Se perderán los datos no guardados.")) {
          Inertia.get("/clientes");
        }
      };
  
      return {
        form,
        guardarCliente,
        cancelar,
      };
    },
  };
  </script>
  
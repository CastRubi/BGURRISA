<template>
    <Layout>
      <div class="p-10 sm:ml-64">
        <div class="mb-12 mt-2 text-center">
          <h2 class="text-4xl font-bold text-black inline-block">
            Detalles de Abonos
          </h2>
          <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
        </div>
  
        <!-- Tabla de abonos -->
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 text-left text-gray-600">Fecha de Abono</th>
                <th class="px-4 py-2 text-left text-gray-600">Monto Abonado</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="abono in abonos"
                :key="abono.id"
                class="hover:bg-gray-50 transition-colors"
              >
                <td class="px-4 py-2 border">{{ abono.fecha_abono }}</td>
                <td class="px-4 py-2 border">{{ abono.monto_abonado }}</td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <!-- Botón para regresar -->
        <div class="flex justify-end mt-6">
          <button
            @click="volverAProveedores"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
          >
            Volver a la lista de proveedores
          </button>
        </div>
      </div>
    </Layout>
  </template>
  
  <script setup>
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@/Layouts/Layout.vue";
  
  // Props recibidos desde el servidor
  const props = defineProps(["abonos"]);
  
  // Función para redirigir a la lista de proveedores
  const volverAProveedores = () => {
    Inertia.visit("/proveedores");
  };
  </script>
  
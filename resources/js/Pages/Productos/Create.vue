<script setup>
import Layout from "@/Layouts/Layout.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    concepto: "",
    precio: "",
});

const enviarFormulario = () => {
    form.post(route('productos.store'));
};
</script>

<template>
  <Layout title="Crear Producto">
    <div class="p-10 sm:ml-64 bg-cover bg-center h-full">
      <div class="mb-12 mt-2 text-center">
        <h2 class="text-4xl font-bold text-black inline-block">
          Protegiendo cada cosecha con calidad y confianza
        </h2>
        <hr class="my-5 border-gray-500" />
      </div>
      <form @submit.prevent="enviarFormulario" class="bg-green-500 bg-opacity-50 p-8 rounded-lg shadow-md max-w-xl mx-auto">
        <div class="mb-6 text-center">
          <h3 class="text-2xl font-semibold text-black">Agregar Producto</h3>
        </div>
        <div class="grid gap-6">
          <!-- Campo de Concepto -->
          <input 
            v-model="form.concepto"
            type="text"
            placeholder="Concepto"
            class="p-3 border rounded-lg w-full"
            required
          />

          <!-- Campo de Precio -->
          <input 
            v-model="form.precio"
            type="number"
            placeholder="Precio"
            class="p-3 border rounded-lg w-full"
            required
          />
        </div>
        <div class="mt-6 flex justify-center gap-4">
          <button 
            type="submit"
            class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition"
          >
            Guardar
          </button>
          <a 
            href="/productos" 
            class="bg-red-500 text-white px-6 py-3 rounded-lg shadow hover:bg-red-600 transition"
          >
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </Layout>
</template>

<template>
  <Layout>
    <div class="p-10 sm:ml-64">
      <div class="mb-12 mt-2 text-center">
        <h2 class="text-4xl font-bold text-black inline-block">
          Agregar Nuevo Proveedor
        </h2>
        <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
      </div>

      <form @submit.prevent="guardarProveedor" class="bg-white p-6 rounded-lg shadow-md">
        <!-- Nombre -->
        <div class="mb-4">
          <label for="nombre" class="block text-gray-700 font-semibold">Nombre del Proveedor:</label>
          <input
            type="text"
            id="nombre"
            v-model="form.nombre"
            class="w-full mt-2 p-2 border rounded"
            placeholder="Ingrese el nombre del proveedor"
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

        <!-- Fecha de Compra -->
        <div class="mb-4">
          <label for="fecha_compra" class="block text-gray-700 font-semibold">Fecha de Compra:</label>
          <input
            type="date"
            id="fecha_compra"
            v-model="form.fecha_compra"
            class="w-full mt-2 p-2 border rounded"
          />
        </div>

        <!-- Marca -->
        <div class="mb-4">
          <label for="marca" class="block text-gray-700 font-semibold">Marca:</label>
          <input
            type="text"
            id="marca"
            v-model="form.marca"
            class="w-full mt-2 p-2 border rounded"
            placeholder="Ingrese la marca del producto"
          />
        </div>

        <!-- Cantidad -->
        <div class="mb-4">
          <label for="cantidad_producto" class="block text-gray-700 font-semibold">Cantidad de Producto:</label>
          <input
            type="number"
            id="cantidad_producto"
            v-model.number="form.cantidad_producto"
            class="w-full mt-2 p-2 border rounded"
            placeholder="Ingrese la cantidad"
            @input="calcularImporte"
          />
        </div>

        <!-- Precio -->
        <div class="mb-4">
          <label for="precio" class="block text-gray-700 font-semibold">Precio por Producto:</label>
          <input
            type="number"
            id="precio"
            v-model.number="form.precio"
            class="w-full mt-2 p-2 border rounded"
            placeholder="Ingrese el precio"
            @input="calcularImporte"
          />
        </div>

     


        <!-- Saldo -->
        <div class="mb-4">
          <label for="saldo" class="block text-gray-700 font-semibold">Saldo:</label>
          <input
            type="number"
            id="saldo"
            v-model.number="form.saldo"
            class="w-full mt-2 p-2 border rounded bg-gray-100"
            readonly
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
      fecha_compra: "",
      marca: "",
      cantidad_producto: 0,
      precio: 0,
      importe: 0,
      abono: 0,
      saldo: 0,
    });

    const calcularImporte = () => {
      form.value.importe = form.value.cantidad_producto * form.value.precio;
      calcularSaldo();
    };

    const calcularSaldo = () => {
      form.value.saldo = form.value.importe - form.value.abono;
    };

    const guardarProveedor = () => {
      if (form.value.nombre && form.value.telefono && form.value.correo) {
        Inertia.post("/proveedores", form.value);
      } else {
        alert("Por favor, completa todos los campos obligatorios.");
      }
    };

    const cancelar = () => {
      if (confirm("¿Deseas cancelar? Se perderán los datos no guardados.")) {
        Inertia.get("/proveedores");
      }
    };

    return {
      form,
      calcularImporte,
      calcularSaldo,
      guardarProveedor,
      cancelar,
    };
  },
};
</script>

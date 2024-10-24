<script setup>
import Layout from "@/Layouts/Layout.vue";
import { ref } from 'vue';

// Simulación de datos de proveedores (puedes reemplazar esto con datos reales de tu API)
const proveedores = ref([
    { id: 1, nombre: 'Provedor A', telefono: '111-222-3333', correo: 'provA@example.com', idProductos: 1, concepto: 'Suministros', precio: 50.00 },
    { id: 2, nombre: 'Provedor B', telefono: '444-555-6666', correo: 'provB@example.com', idProductos: 2, concepto: 'Equipos', precio: 150.00 },
    // Agrega más proveedores según sea necesario
]);

// Funciones para agregar y eliminar proveedores (puedes implementar la lógica real más tarde)
const eliminarProveedor = (proveedor) => {
    console.log(`Proveedor eliminado: ${proveedor.nombre}`);
    proveedores.value = proveedores.value.filter(p => p.id !== proveedor.id);
};

const agregarProveedor = () => {
    console.log('Agregar proveedor');
    // Implementa la lógica para agregar un nuevo proveedor
};

const verDetallesProveedor = (proveedor) => {
    console.log(`Detalles del proveedor: ${proveedor.nombre}`);
    // Implementa la lógica para mostrar detalles del proveedor
};
</script>

<template #header>
    <Layout title="Proveedores">
        <!-- Contenedor principal con fondo de imagen -->
        <div
            class="p-10 sm:ml-64"
            style="
               background-image: url('/img/fondo.avif');
                background-size: cover;
                background-position: center;
                height: 100vh;">

            <!-- Espacio para la frase -->
            <div class="mb-12 mt-2 text-center">
                <h2 class="text-4xl font-bold text-black" style="text-shadow: 0 0 4px white">
                    Gestión de Proveedores
                </h2>
                <hr class="my-5 border-gray-300" style="margin-top: 50px; border-top: 2px solid black" />
            </div>

            <!-- Cuadro de datos de todos los proveedores -->
            <div class="bg-white p-4 rounded shadow-md">
                <h3 class="text-xl font-bold text-center">Datos de Proveedores</h3>
                <table class="min-w-full mt-4">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Nombre</th>
                            <th class="border px-4 py-2 hidden sm:table-cell">Teléfono</th>
                            <th class="border px-4 py-2 hidden sm:table-cell">Correo</th>
                            <th class="border px-4 py-2 hidden sm:table-cell">Concepto</th>
                            <th class="border px-4 py-2 hidden sm:table-cell">Precio</th>
                            <th class="border px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="proveedor in proveedores" :key="proveedor.id">
                            <td class="border px-4 py-2">{{ proveedor.id }}</td>
                            <td class="border px-4 py-2">{{ proveedor.nombre }}</td>
                            <td class="border px-4 py-2 hidden sm:table-cell">{{ proveedor.telefono }}</td>
                            <td class="border px-4 py-2 hidden sm:table-cell">{{ proveedor.correo }}</td>
                            <td class="border px-4 py-2 hidden sm:table-cell">{{ proveedor.concepto }}</td>
                            <td class="border px-4 py-2 hidden sm:table-cell">${{ proveedor.precio.toFixed(2) }}</td>
                            <td class="border px-4 py-2 flex flex-col sm:flex-row gap-2">
                                <button @click="eliminarProveedor(proveedor)" class="bg-red-500 text-white px-2 py-1 rounded">
                                    Eliminar
                                </button>
                                <button @click="verDetallesProveedor(proveedor)" class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    Detalles
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Botones para agregar proveedor y ver detalles -->
            <div class="mt-4 text-center">
                <button @click="agregarProveedor" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
                    Agregar Proveedor
                </button>
                
            </div>
        </div>
    </Layout>
</template>

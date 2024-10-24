<script setup>
import Layout from "@/Layouts/Layout.vue";
import { ref } from 'vue';

// Simulación de datos de clientes (puedes reemplazar esto con datos reales de tu API)
const clientes = ref([
    { id: 1, nombre: 'Juan Pérez', telefono: '123-456-7890', correo: 'juan@example.com', totalDeuda: 100.50 },
    { id: 2, nombre: 'María Gómez', telefono: '098-765-4321', correo: 'maria@example.com', totalDeuda: 250.00 },
    // Agrega más clientes según sea necesario
]);

// Funciones para agregar y eliminar clientes (puedes implementar la lógica real más tarde)
const eliminarCliente = (cliente) => {
    console.log(`Cliente eliminado: ${cliente.nombre}`);
    clientes.value = clientes.value.filter(c => c.id !== cliente.id);
};

const agregarCliente = () => {
    console.log('Agregar cliente');
    // Implementa la lógica para agregar un nuevo cliente
};

const verDetallesCliente = (cliente) => {
    console.log(`Detalles del cliente: ${cliente.nombre}`);
    // Implementa la lógica para mostrar detalles del cliente
};
</script>

<template #header>
    <Layout title="Dashboard">
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
                    Protegiendo cada cosecha con calidad y confianza
                </h2>
                <hr class="my-5 border-gray-300" style="margin-top: 50px; border-top: 2px solid black" />
            </div>

            <!-- Cuadro de datos de todos los clientes -->
            <div class="bg-white p-4 rounded shadow-md">
                <h3 class="text-xl font-bold text-center">Datos de Clientes</h3>
                <table class="min-w-full mt-4">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Nombre</th>
                            <th class="border px-4 py-2 hidden sm:table-cell">Teléfono</th>
                            <th class="border px-4 py-2 hidden sm:table-cell">Correo</th>
                            <th class="border px-4 py-2 hidden sm:table-cell">Total Deuda</th>
                            <th class="border px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cliente in clientes" :key="cliente.id">
                            <td class="border px-4 py-2">{{ cliente.id }}</td>
                            <td class="border px-4 py-2">{{ cliente.nombre }}</td>
                            <td class="border px-4 py-2 hidden sm:table-cell">{{ cliente.telefono }}</td>
                            <td class="border px-4 py-2 hidden sm:table-cell">{{ cliente.correo }}</td>
                            <td class="border px-4 py-2 hidden sm:table-cell">${{ cliente.totalDeuda.toFixed(2) }}</td>
                            <td class="border px-4 py-2 flex flex-col sm:flex-row gap-2">
                                <button @click="eliminarCliente(cliente)" class="bg-red-500 text-white px-2 py-1 rounded">
                                    Eliminar
                                </button>
                                <button @click="verDetallesCliente(cliente)" class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    Detalles
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Botones para agregar cliente y ver detalles -->
            <div class="mt-4 text-center">
                <button @click="agregarCliente" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
                    Agregar Cliente
                </button>
                
            </div>
        </div>
    </Layout>
</template>

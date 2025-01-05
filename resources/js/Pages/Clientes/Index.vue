<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Layout from "@/Layouts/Layout.vue";

// Datos de clientes pasados desde el backend
const props = defineProps(['clientes']);

// Estado del modal y cliente a eliminar
const mostrarModalCliente = ref(false);
const clienteAEliminar = ref(null);

// Función para redirigir a la página de creación de cliente
const agregarCliente = () => {
    Inertia.visit('/clientes/create');
};

// Función para abrir el modal de eliminación
const abrirModalEliminarCliente = (cliente) => {
    clienteAEliminar.value = cliente;
    mostrarModalCliente.value = true;
};

const confirmarEliminarCliente = () => {
    Inertia.delete(`/clientes/${clienteAEliminar.value.id}`, {
        onSuccess: () => {
            mostrarModalCliente.value = false; // Cierra el modal tras eliminar
            Inertia.visit('/clientes/index');
        },
    });
};



// Función para cerrar el modal de eliminación
const cerrarModalCliente = () => {
    mostrarModalCliente.value = false;
};

// Función para redirigir a la página de edición de cliente
const editarCliente = (cliente) => {
    Inertia.visit(`/clientes/${cliente.id}/edit`);
};

// Función para ver los detalles del cliente
const verDetallesCliente = (cliente) => {
    Inertia.visit(`/clientes/${cliente.id}`);
};
</script>

<template>
    <Layout title="Clientes">
        <div class="p-10 sm:ml-64">
            <div class="mb-12 mt-2 text-center">
                <h2 class="text-4xl font-bold text-black inline-block">
                    Protegiendo cada cosecha con calidad y confianza
                </h2>
                <hr class="my-5 border-gray-500" />
            </div>

            <!-- Tabla de clientes -->
            <div class="bg-green-500 bg-opacity-50 p-4 rounded shadow-md">
                <h3 class="text-xl font-bold text-center text-black">Datos de Clientes</h3>
                <table class="min-w-full mt-4">
                    <thead>
                        <tr>
                            <th class="font-bold border px-4 py-2 text-black">ID</th>
                            <th class="font-bold border px-4 py-2 text-black">Nombre</th>
                            <th class="font-bold border px-4 py-2 hidden sm:table-cell text-black">Correo</th>
                            <th class="font-bold border px-4 py-2 hidden sm:table-cell text-black">Telefono</th>
                            <th class="font-bold border px-4 py-2 text-black">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cliente in clientes" :key="cliente.id">
                            <td class="font-bold border px-4 py-2 text-black">{{ cliente.id }}</td>
                            <td class="font-bold border px-4 py-2 text-black">{{ cliente.nombre }}</td>
                            <td class="font-bold border px-4 py-2 hidden sm:table-cell text-black">{{ cliente.email }}</td>
                            <td class="font-bold border px-4 py-2 hidden sm:table-cell text-black">{{ cliente.telefono }}</td>
                            <td class="font-bold border px-4 py-2 flex flex-col sm:flex-row gap-2">
                                <button @click="abrirModalEliminarCliente(cliente)" class="bg-red-500 text-white px-2 py-1 rounded">
                                    Eliminar
                                </button>
                                <button @click="editarCliente(cliente)" class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-center">
                <button @click="agregarCliente" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Agregar Cliente
                </button>
                <a href="/dashboard" class="bg-red-500 text-white px-4 py-2 rounded ml-2">Salir</a>
            </div>
        </div>

        <!-- Modal de confirmación para eliminar cliente -->
        <div v-if="mostrarModalCliente" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full text-center">
                <h3 class="text-xl font-semibold mb-4">Confirmación de eliminación</h3>
                <p>¿Estás seguro de que deseas eliminar al cliente <strong>{{ clienteAEliminar?.nombre }}</strong>?</p>
                <div class="flex justify-center mt-6 gap-4">
                    <button @click="confirmarEliminarCliente" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                    <button @click="cerrarModalCliente" class="bg-gray-300 text-black px-4 py-2 rounded">Cancelar</button>
                </div>
            </div>
        </div>
    </Layout>
</template>

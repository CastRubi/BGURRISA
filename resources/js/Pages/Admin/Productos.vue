<script setup>
import Layout from "@/Layouts/Layout.vue";
import { ref } from 'vue';

// Simulación de datos de productos (puedes reemplazar esto con datos reales de tu API)
const productos = ref([
    { id: 1, concepto: 'Producto A', total: 100, precio: 20.00 },
    { id: 2, concepto: 'Producto B', total: 200, precio: 30.00 },
    // Agrega más productos según sea necesario
]);

// Funciones para agregar y eliminar productos (puedes implementar la lógica real más tarde)
const eliminarProducto = (producto) => {
    console.log(`Producto eliminado: ${producto.concepto}`);
    productos.value = productos.value.filter(p => p.id !== producto.id);
};

const agregarProducto = () => {
    console.log('Agregar producto');
    // Implementa la lógica para agregar un nuevo producto
};

const verDetallesProducto = (producto) => {
    console.log(`Detalles del producto: ${producto.concepto}`);
    // Implementa la lógica para mostrar detalles del producto
};
</script>

<template #header>
    <Layout title="Productos">
        <!-- Contenedor principal con fondo de imagen -->
        <div
            class="p-10 sm:ml-64"
            style="background-image: url('/img/fondo.avif'); background-size: cover; background-position: center; height: 100vh;">

            <!-- Espacio para la frase -->
            <div class="mb-12 mt-2 text-center">
                <h2 class="text-4xl font-bold text-black" style="text-shadow: 0 0 4px white">
                    Gestión de Productos
                </h2>
                <hr class="my-5 border-gray-300" style="margin-top: 50px; border-top: 2px solid black" />
            </div>

            <!-- Cuadro de datos de todos los productos -->
            <div class="bg-white p-4 rounded shadow-md">
                <h3 class="text-xl font-bold text-center">Datos de Productos</h3>
                <table class="min-w-full mt-4">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2 text-center">ID</th>
                            <th class="border px-4 py-2 text-center">Concepto</th>
                            <th class="border px-4 py-2 text-center hidden sm:table-cell">Total</th>
                            <th class="border px-4 py-2 text-center hidden sm:table-cell">Precio</th>
                            <th class="border px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="producto in productos" :key="producto.id">
                            <td class="border px-4 py-2 text-center">{{ producto.id }}</td>
                            <td class="border px-4 py-2 text-center">{{ producto.concepto }}</td>
                            <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ producto.total }}</td>
                            <td class="border px-4 py-2 text-center hidden sm:table-cell">${{ producto.precio.toFixed(2) }}</td>
                            <td class= "border px-4 py-2 flex flex-col sm:flex-row gap-2">
                                <button @click="eliminarProducto(producto)" class="bg-red-500 text-white px-2 py-1 rounded">
                                    Eliminar
                                </button>
                                <button @click="verDetallesProducto(producto)" class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    Detalles
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Botones para agregar producto -->
            <div class="mt-4 text-center">
                <button @click="agregarProducto" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
                    Agregar Producto
                </button>
            </div>
        </div>
    </Layout>
</template>

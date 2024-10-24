<script setup>
import Layout from "@/Layouts/Layout.vue";
import { ref, computed, watch } from 'vue';
import jsPDF from 'jspdf';

// Simulación de datos de clientes y productos
const clientes = ref([
    { id: 1, nombre: 'Juan Pérez' },
    { id: 2, nombre: 'María Gómez' },
    { id: 3, nombre: 'María martinez' },
]);

const productos = ref([
    { id: 1, concepto: 'Suministro A', cantidadDisponible: 100, precio: 20.00 },
    { id: 2, concepto: 'Suministro B', cantidadDisponible: 50, precio: 30.00 },
    { id: 3, concepto: 'Suministro c', cantidadDisponible: 50, precio: 30.00 },

]);

// Variables reactivas
const ventaId = ref(Date.now());
const selectedCliente = ref(null);
const selectedProducto = ref(null);
const cantidad = ref(1);
const productosSeleccionados = ref([]);
const totalCompra = ref(0);
const totalPagar = ref(0);
const abonos = ref(0);

// Computed para mostrar el mensaje de disponibilidad de productos
const mensajeDisponibilidad = computed(() => {
    if (selectedProducto.value) {
        const producto = productos.value.find(p => p.id === selectedProducto.value.id);
        const disponibilidad = producto.cantidadDisponible >= cantidad.value 
            ? `Cantidad disponible: ${producto.cantidadDisponible}` 
            : `No hay suficiente stock. Disponibles: ${producto.cantidadDisponible}`;
        return `${disponibilidad}. Precio: $${producto.precio.toFixed(2)}`;
    }
    return '';
});

// Función para agregar producto a la lista de ventas
const agregarProducto = () => {
    if (selectedProducto.value && cantidad.value > 0) {
        const productoExistente = productosSeleccionados.value.find(p => p.id === selectedProducto.value.id);
        if (productoExistente) {
            productoExistente.cantidad += cantidad.value;
        } else {
            productosSeleccionados.value.push({ ...selectedProducto.value, cantidad: cantidad.value });
        }
        calcularTotal();
        selectedProducto.value = null;
        cantidad.value = 1; // Resetear cantidad
    }
};

// Función para calcular el total de la compra
const calcularTotal = () => {
    totalCompra.value = productosSeleccionados.value.reduce((total, producto) => {
        return total + (producto.precio * producto.cantidad);
    }, 0);
    totalPagar.value = totalCompra.value - abonos.value;
};

// Función para registrar la venta y generar el ticket
const registrarVenta = () => {
    console.log(`Venta registrada: ID ${ventaId.value}, Cliente: ${selectedCliente.value.nombre}`);
    console.log(productosSeleccionados.value);

    // Generar PDF
    const doc = new jsPDF();
    doc.text(`Venta ID: ${ventaId.value}`, 10, 10);
    doc.text(`Cliente: ${selectedCliente.value.nombre}`, 10, 20);
    productosSeleccionados.value.forEach((producto, index) => {
        doc.text(`${index + 1}. ${producto.concepto} - Cantidad: ${producto.cantidad} - Precio: $${producto.precio.toFixed(2)}`, 10, 30 + (index * 10));
    });
    doc.text(`Total Compra: $${totalCompra.value.toFixed(2)}`, 10, 30 + (productosSeleccionados.value.length * 10));
    doc.text(`Total a Pagar: $${totalPagar.value.toFixed(2)}`, 10, 40 + (productosSeleccionados.value.length * 10));
    doc.save(`venta_${ventaId.value}.pdf`);
};

const cancelarVenta = () => {
    // Reiniciar todos los campos y eliminar productos seleccionados
    selectedCliente.value = null;
    selectedProducto.value = null;
    cantidad.value = 1;
    productosSeleccionados.value = [];
    totalCompra.value = 0;
    abonos.value = 0;
    totalPagar.value = 0;
    // Reiniciar el mensaje de disponibilidad si lo necesitas
    mensajeDisponibilidad.value = ''; 
};

// Observadores para recalcular cuando cambian los valores
watch([abonos], calcularTotal);
</script>

<template #header>
    <Layout title="Registro de Ventas">
        <div class="p-10 sm:ml-64" style="background-image: url('/img/fondo.avif'); background-size: cover; background-repeat: no-repeat; background-position: center;">
            <div class="mb-12 mt-2 text-center">
                <h2 class="text-4xl font-bold text-black">Registro de Ventas</h2>
                <hr class="my-5 border-gray-300" style="border-top: 2px solid black" />
            </div>

            <div class="flex flex-col sm:flex-row bg-white p-4 rounded shadow-md">
                <!-- Lado izquierdo -->
                <div class="w-full sm:w-1/2 p-2">
                    <h3 class="text-xl mb-4 font-bold text-center">Datos de Venta</h3>

                    <div class="mt-4 text-center">
                        <label class="block mb-2">ID de Venta:</label>
                        <input type="text" v-model="ventaId" disabled class="border rounded w-1/3 py-2 px-3 mx-auto" />
                    </div>

                    <div class="mt-4 text-center">
                        <label class="block mb-2">Seleccionar Cliente:</label>
                        <select v-model="selectedCliente" class="border rounded w-1/3 py-2 px-3 mx-auto">
                            <option v-for="cliente in clientes" :key="cliente.id" :value="cliente">{{ cliente.nombre }}</option>
                            <option value="">Seleccione un cliente</option>
                        </select>
                    </div>

                    <div class="mt-4 text-center">
                        <label class="block mb-2">Seleccionar Producto:</label>
                        <select v-model="selectedProducto" class="border rounded w-1/3 py-2 px-3 mx-auto">
                            <option v-for="producto in productos" :key="producto.id" :value="producto">{{ producto.concepto }}</option>
                            <option value="">Seleccione un producto</option>
                        </select>
                    </div>

                    <p class="text-red-500 text-center">{{ mensajeDisponibilidad }}</p>

                    <div class="mt-4 text-center">
                        <label class="block mb-2">Cantidad:</label>
                        <input type="number" v-model="cantidad" min="1" class="border rounded w-1/3 py-2 px-3 mx-auto" />
                    </div>

                    <div class="mt-4 text-center">
                        <button @click="agregarProducto" class="bg-green-500 text-white px-4 py-2 rounded">
                            Agregar Producto
                        </button>
                    </div>
                </div>

                <!-- Lado derecho -->
                <div class="w-full sm:w-1/2 p-2">
                    <h3 class="text-xl font-bold text-center">Productos Seleccionados</h3>
                    <!-- Tabla de productos seleccionados -->
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Productos</th>
                                <th class="border px-4 py-2">Cant</th>
                                <th class="border px-4 py-2 hidden sm:table-cell">P Unitario</th>
                                <th class="border px-4 py-2 hidden sm:table-cell">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="producto in productosSeleccionados" :key="producto.id">
                                <td class="border px-4 py-2">{{ producto.concepto }}</td>
                                <td class="border px-4 py-2">{{ producto.cantidad }}</td>
                                <td class="border px-4 py-2 hidden sm:table-cell">${{ producto.precio.toFixed(2) }}</td>
                                <td class="border px-4 py-2 hidden sm:table-cell">${{ (producto.precio * producto.cantidad).toFixed(2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4 text-center">
                        <label class="block mb-2">Total de Compra:</label>
                        <input type="text" v-model="totalCompra" disabled class="border rounded w-1/3 py-2 px-3 mx-auto" />
                    </div>

                    <div class="mt-4 text-center">
                        <label class="block mb-2">Abonos:</label>
                        <input type="number" v-model="abonos" min="0" class="border rounded w-1/3 py-2 px-3 mx-auto" />
                    </div>

                    <div class="mt-4 text-center">
                        <label class="block mb-2">Total a Pagar:</label>
                        <input type="text" v-model="totalPagar" disabled class="border rounded w-1/3 py-2 px-3 mx-auto" />
                    </div>

                    <div class="mt-4 text-center">
                        <button @click="registrarVenta" class="bg-blue-500 text-white px-4 py-2 rounded mb-5">
                            Registrar Venta
                        </button>
                        <button @click="cancelarVenta" class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                            Cancelar Venta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>


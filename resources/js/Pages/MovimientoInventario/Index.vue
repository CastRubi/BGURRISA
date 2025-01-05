<template>
    <Layout title="Movimientos de Inventario">
        <div class="p-10 sm:ml-64">
            <div class="mb-12 mt-2 text-center">
                <h2 class="text-4xl font-bold text-black inline-block">
                    Protegiendo cada cosecha con calidad y confianza
                </h2>
                <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
            </div>

            <!-- Tabla de Movimientos de Inventario -->
            <div class="bg-green-500 bg-opacity-50 p-4 rounded shadow-md">
                <h3 class="text-xl font-bold text-center text-black">Lista de Movimientos</h3>
                <table class="min-w-full mt-4 table-auto mx-4">
                    <thead>
                        <tr>
                            <th class="border text-black px-2 py-2 text-center">ID</th>
                            <th class="border text-black px-2 py-2 text-center">Producto</th>
                            <th class="border text-black px-2 py-2 text-center">Cantidad</th>
                            <th class="border text-black px-2 py-2 text-center">Tipo de Movimiento</th>
                            <th class="border text-black px-2 py-2 text-center">Fecha</th>
                            <th class="border text-black px-2 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="movimiento in movimientos" :key="movimiento.id">
                            <td class="border px-2 py-2 text-center">{{ movimiento.id }}</td>
                            <td class="border px-2 py-2 text-center">{{ movimiento.producto ? movimiento.producto.concepto : 'N/A' }}</td>
                            <td class="border px-2 py-2 text-center">{{ movimiento.cantidad }}</td>
                            <td class="border px-2 py-2 text-center">{{ movimiento.tipo_movimiento }}</td>
                            <td class="border px-2 py-2 text-center">{{ movimiento.fecha_movimiento }}</td>
                            <td class="border px-2 py-2 text-center flex justify-center items-center gap-2">
                                <button @click="editarMovimiento(movimiento)" class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    Editar
                                </button>
                                <button @click="abrirModalEliminarMovimiento(movimiento)" class="bg-red-500 text-white px-2 py-1 rounded">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Botón para agregar un nuevo movimiento -->
                <div class="mt-4 text-center">
                    <button @click="irAAgregarMovimiento" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Agregar Movimiento
                    </button>
                </div>

                <!-- Botón para salir y regresar al dashboard -->
                <div class="mt-2 text-center">
                    <button @click="irAlDashboard" class="bg-gray-500 text-white px-4 py-2 rounded">
                        Salir
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación de Eliminación -->
        <div v-if="mostrarModalEliminar" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-bold text-center">¿Estás seguro de eliminar este movimiento?</h3>
                <div class="flex justify-center gap-4 mt-4">
                    <button @click="confirmarEliminarMovimiento" class="bg-red-500 text-white px-4 py-2 rounded">
                        Confirmar
                    </button>
                    <button @click="cerrarModal" class="bg-gray-500 text-white px-4 py-2 rounded">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "@/Layouts/Layout.vue";
import { ref } from "vue";
import { Inertia } from '@inertiajs/inertia';

export default {
    components: { Layout },
    props: {
        movimientos: Array,
    },
    setup(props) {
        const movimientos = ref(props.movimientos);
        const mostrarModalEliminar = ref(false);
        const movimientoAEliminar = ref(null);

        // Método para redirigir al formulario de creación
        const irAAgregarMovimiento = () => {
            Inertia.visit('/movimiento-inventario/create');
        };

        // Método para editar un movimiento
        const editarMovimiento = (movimiento) => {
            Inertia.visit(`/movimiento-inventario/${movimiento.id}/edit`);
        };

        // Método para abrir el modal de eliminación
        const abrirModalEliminarMovimiento = (movimiento) => {
            // Establece el movimiento a eliminar y muestra el modal
            movimientoAEliminar.value = movimiento;
            mostrarModalEliminar.value = true;
        };

        // Método para cerrar el modal
        const cerrarModal = () => {
            mostrarModalEliminar.value = false;
            movimientoAEliminar.value = null;
        };

        // Método para confirmar la eliminación del movimiento
        const confirmarEliminarMovimiento = () => {
            Inertia.delete(`/movimiento-inventario/${movimientoAEliminar.value.id}`, {
                onSuccess: () => {
                    alert('Movimiento eliminado correctamente.');
                    cerrarModal();  // Cierra el modal después de la eliminación
                },
                onError: (err) => {
                    console.error('Error al eliminar el movimiento:', err);
                    alert('Ocurrió un error al intentar eliminar el movimiento.');
                },
            });
        };

        // Método para redirigir al dashboard
        const irAlDashboard = () => {
            Inertia.visit('/dashboard');
        };

        return {
            movimientos,
            irAAgregarMovimiento,
            editarMovimiento,
            abrirModalEliminarMovimiento,
            cerrarModal,
            confirmarEliminarMovimiento,
            mostrarModalEliminar,
            irAlDashboard,
        };
    },
};
</script>

<style scoped>
/* Estilos adicionales para el modal */
.fixed {
    z-index: 9999;
}
.bg-gray-500 {
    background-color: rgba(0, 0, 0, 0.5);
}
.bg-white {
    background-color: white;
}
</style>

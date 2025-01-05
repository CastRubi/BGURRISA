<template>
    <Layout title="Editar Movimiento de Inventario">
        <div class="p-10 sm:ml-64">
            <div class="mb-12 mt-2 text-center">
                <h2 class="text-4xl font-bold text-white inline-block" style="background-color: rgba(34, 197, 94, 0.5);">
                    Editar Movimiento de Inventario
                </h2>
                <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
            </div>

            <div class="bg-green-500 bg-opacity-50 p-4 rounded shadow-md">
                <h3 class="text-xl font-bold text-center text-black">Formulario de Edición</h3>
                <form @submit.prevent="guardarMovimiento">
                    <div class="mb-4">
                        <label for="producto" class="block text-black font-bold">Producto</label>
                        <select v-model="form.producto_id" id="producto" class="w-full p-2 mt-2 rounded bg-white border">
                            <option v-for="producto in productos" :key="producto.id" :value="producto.id">
                                {{ producto.concepto }}
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="cantidad" class="block text-black font-bold">Cantidad</label>
                        <input
                            type="number"
                            id="cantidad"
                            v-model="form.cantidad"
                            class="w-full p-2 mt-2 rounded bg-white border"
                            :class="{'border-red-500': errors.cantidad}"
                            min="1"
                        />
                        <span v-if="errors.cantidad" class="text-red-500 text-sm">{{ errors.cantidad }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="tipo_movimiento" class="block text-black font-bold">Tipo de Movimiento</label>
                        <select v-model="form.tipo_movimiento" id="tipo_movimiento" class="w-full p-2 mt-2 rounded bg-white border">
                            <option value="entrada">Entrada</option>
                            <option value="salida">Salida</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="fecha_movimiento" class="block text-black font-bold">Fecha del Movimiento</label>
                        <input
                            type="date"
                            id="fecha_movimiento"
                            v-model="form.fecha_movimiento"
                            class="w-full p-2 mt-2 rounded bg-white border"
                            :class="{'border-red-500': errors.fecha_movimiento}"
                        />
                    </div>

                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
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
        movimiento: Object,
        productos: Array,
    },
    setup(props) {
        const form = ref({
            producto_id: props.movimiento.producto_id,
            cantidad: props.movimiento.cantidad,
            tipo_movimiento: props.movimiento.tipo_movimiento,
            fecha_movimiento: props.movimiento.fecha_movimiento,
        });

        const errors = ref({});

        const guardarMovimiento = () => {
            Inertia.put(`/movimiento-inventario/${props.movimiento.id}`, form.value, {
                onError: (err) => {
                    errors.value = err;
                },
                onSuccess: () => {
                    Inertia.visit('/movimiento-inventario');
                }
            });
        };

        return {
            form,
            errors,
            guardarMovimiento,
        };
    }
};
</script>

<style scoped>
/* Estilos adicionales */
</style>

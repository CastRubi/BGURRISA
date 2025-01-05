<template>
    <div>
        <input type="number" v-model="montoAbono" placeholder="Monto de abono">
        <button @click="realizarAbono">Realizar abono</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            montoAbono: 0,  // Almacena el monto de abono que el usuario ingresa
        };
    },
    methods: {
        realizarAbono() {
            // Enviar el monto del abono al backend
            axios.post(`/ventas/${this.ventaId}/abonos`, {
                monto_abono: this.montoAbono,  // Solo envía el monto, no el valor de abonos
            })
            .then(response => {
                console.log('Abono realizado correctamente');
                // Actualiza la UI si es necesario, por ejemplo:
                this.venta.abonos += this.montoAbono;  // Asegúrate de actualizar solo en la vista
            })
            .catch(error => {
                console.error('Error al realizar el abono:', error);
            });
        },
    },
};
</script>

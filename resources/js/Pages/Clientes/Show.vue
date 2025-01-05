<template>
    <div>
       <h1>Detalles del Cliente</h1>
       <p>Nombre: {{ cliente.nombre }}</p>
       <p>Teléfono: {{ cliente.telefono }}</p>
       <p>Correo: {{ cliente.correo }}</p>
    </div>
 </template>
 
 <script setup>
 import { ref, onMounted } from 'vue';
 
 const cliente = ref({});
 
 onMounted(() => {
    // Aquí puedes cargar el cliente desde el backend
 });
 </script>
 
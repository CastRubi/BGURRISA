<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>
<template>
    <Head title="Welcome" />
    <div
        class="bg-cover bg-center bg-no-repeat min-h-screen text-black/50 dark:text-white/50 overflow-hidden"
        style="background-image: url('/Img/bienvenidos.jpg');"
    >
        <!-- Barra de navegación fija dentro de la línea negra -->
        <div class="bg-black text-white fixed top-0 left-0 w-full z-10">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Logo alineado a la izquierda -->
                <div>
                    <img src="/Img/log.jpeg" alt="Logo" class="h-20 logo-verde">
                </div>

                <!-- Frase centrada -->
                <div class="absolute left-1/2 transform -translate-x-1/2">
                    <span class="text-xl font-semibold text-green-500">
                        Protegiendo cada cosecha con calidad y confianza
                    </span>
                </div>

                <!-- Botón de iniciar sesión a la derecha -->
                <nav v-if="canLogin">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="rounded-md px-4 py-2 text-xl font-bold text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Iniciar Sesión
                        </Link>
                    </template>
                </nav>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="relative min-h-screen flex flex-col items-center justify-center pt-20">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <!-- Título "Bienvenido" dentro de un cuadro con efecto difuminado -->
                <header class="py-10">
                    <div class="bg-black bg-opacity-60 p-10 rounded-lg text-center">
                        <h1 class="text-6xl font-extrabold text-white">
                            Bienvenido
                        </h1>
                    </div>
                </header>
            </div>
        </div>
    </div>
</template>


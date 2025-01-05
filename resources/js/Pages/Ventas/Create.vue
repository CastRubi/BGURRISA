<template>
    <Layout title="Crear Venta">
      <div class="p-10 sm:ml-64">
        <div class="mb-12 mt-2 text-center">
          <h2 class="text-4xl font-bold text-black inline-block">
            Protegiendo cada cosecha con calidad y confianza
          </h2>
          <hr class="my-5 border-gray-500" style="margin-top: 50px; border-top: 2px solid black;" />
        </div>
  
        <div class="bg-green-500 bg-opacity-50 p-4 rounded shadow-md">
          <h3 class="text-xl font-bold text-center text-black">Crear Venta</h3>
  
          <form @submit.prevent="crearVenta">
            <div class="mt-4">
              <label for="cliente_id" class="block text-black font-semibold">Seleccionar Cliente</label>
              <select id="cliente_id" v-model="venta.cliente_id" class="mt-2 p-2 rounded w-full" required>
                <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                  {{ cliente.nombre }} ({{ cliente.telefono }})
                </option>
              </select>
            </div>
  
            <div class="mt-4">
              <label for="productos" class="block text-black font-semibold">Seleccionar Producto</label>
              <select v-model="selectedProductId" class="p-2 rounded w-full">
                <option disabled value="">Seleccione un producto</option>
                <option v-for="producto in productos" :key="producto.id" :value="producto.id">
                  {{ producto.concepto }}
                </option>
              </select>
            </div>
  
            <div class="mt-4 text-center">
              <button type="button" @click="agregarProducto(selectedProductId)" class="bg-blue-500 text-white p-2 rounded">
                Agregar Producto
              </button>
            </div>
  
            <table class="mt-4 w-full bg-white rounded shadow-md">
              <thead>
                <tr class="bg-gray-200 text-black">
                  <th class="p-2">Producto</th>
                  <th class="p-2">Cantidad</th>
                  <th class="p-2">Precio Unitario</th>
                  <th class="p-2">Total</th>
                  <th class="p-2">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(producto, index) in venta.productos" :key="producto.id">
                  <td class="p-2">{{ producto.concepto }}</td>
                  <td class="p-2">
                    <input
                      type="number"
                      v-model.number="producto.cantidad"
                      class="p-2 rounded w-full"
                      min="1"
                      :max="producto.cantidadDisponible"
                      @input="actualizarCantidad(index)"
                    />
                  </td>
                  <td class="p-2">{{ producto.precio_unitario }}</td>
                  <td class="p-2">{{ producto.total }}</td>
                  <td class="p-2">
                    <button type="button" @click="eliminarProducto(index)" class="bg-red-500 text-white p-2 rounded">
                      Eliminar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
  
            <div class="mt-4">
              <label for="total_compra" class="block text-black font-semibold">Total de la Compra</label>
              <input type="number" v-model="venta.total_compra" class="p-2 rounded w-full" readonly />
            </div>
  
  
            <div class="mt-4">
              <label for="total_pagar" class="block text-black font-semibold">Total a Pagar</label>
              <input type="number" v-model="venta.total_pagar" class="p-2 rounded w-full" readonly />
            </div>
  
            <div class="mt-6 text-center">
              <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">
                Crear Venta
              </button>
            </div>
          </form>
        </div>
      </div>
    </Layout>
  </template>
  
  <script>
  import Layout from "@/Layouts/Layout.vue";
  import { reactive, watch } from "vue";
  import { Inertia } from "@inertiajs/inertia";
  
  export default {
    components: { Layout },
    props: {
      productos: Array,
      clientes: Array,
    },
    setup(props) {
      const venta = reactive({
        cliente_id: "",
        productos: [],
        total_compra: 0,
        abonos: 0,
        total_pagar: 0,
      });
  
      const selectedProductId = reactive({ id: "" });
  
      const agregarProducto = (productoId) => {
        const producto = props.productos.find((p) => p.id === productoId);
        if (producto && !venta.productos.some(p => p.id === producto.id)) {
          venta.productos.push({
            id: producto.id,
            concepto: producto.concepto,
            cantidad: 1,
            precio_unitario: producto.precio,
            cantidadDisponible: producto.cantidadDisponible,
            total: producto.precio,
          });
          calcularTotalCompra();
        }
      };
  
      const eliminarProducto = (index) => {
        venta.productos.splice(index, 1);
        calcularTotalCompra();
      };
  
      const actualizarCantidad = (index) => {
        const producto = venta.productos[index];
        producto.total = producto.precio_unitario * producto.cantidad;
        calcularTotalCompra();
      };
  
      const calcularTotalCompra = () => {
        venta.total_compra = venta.productos.reduce((total, producto) => {
          return total + producto.total;
        }, 0);
        calcularTotalPagar();
      };
  
      const calcularTotalPagar = () => {
        venta.total_pagar = Math.max(venta.total_compra - venta.abonos, 0);
      };
  
      watch(
        () => venta.abonos,
        () => calcularTotalPagar()
      );
  
      const crearVenta = () => {
        Inertia.post("/ventas", venta, {
          onSuccess: () => {
            Inertia.visit("/ventas");
          },
        });
      };
  
      return {
        venta,
        selectedProductId,
        agregarProducto,
        eliminarProducto,
        actualizarCantidad,
        calcularTotalCompra,
        calcularTotalPagar,
        crearVenta,
      };
    },
  };
  </script>
  
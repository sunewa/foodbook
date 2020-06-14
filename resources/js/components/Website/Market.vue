<template>
  <!-- Page Content -->
  <div class="container">
    <!-- Page Heading -->
    <h1 class="my-4">
      Marketplace
      <small>All delicious foods you can get at your doorstep</small>
    </h1>

    <div class="row">
      <div class="col-lg-3 col-sm-6 mb-3" v-for="product in products" :key="product.id">
        <ProductComponent v-bind:product="product"></ProductComponent>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</template>

<script>
import ProductComponent from "./ProductComponent";
export default {
  components: {
    ProductComponent
  },
  data() {
    return {
      products: []
    };
  },
  created() {
    this.loadProducts();
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    loadProducts() {
      axios.get("/api/home/products").then(response => {
        this.products = response.data.products;
      });
    }
  }
};
</script>

<template>
  <div class="container">
    <div class="row mt-2">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Purchase History</h3>

            <div class="card-tools">
              <!-- Button trigger modal -->
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Message</th>
                  <th>Products</th>
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="order.length == 0">
                  <td colspan="4">No products available</td>
                </tr>
                <tr v-for="product in order" :key="product.id">
                  <td>{{ product.buyer_name }}</td>
                  <td>{{ product.buyer_address }}</td>
                  <td>{{ product.buyer_contact }}</td>
                  <td>{{ product.buyer_email }}</td>
                  <td>{{ product.message }}</td>
                  <td>
                    <table>
                      <tr>
                        <td>Name</td>
                        <td>Quantity</td>
                        <td>Price</td>
                        <td>Amount</td>
                      </tr>
                      <tr v-for="detail in product.details" :key="detail.id">
                        <td>{{detail.product_name}}</td>
                        <td>{{ detail.price }}</td>
                        <td>{{ detail.quantity}}</td>
                        <td>{{ detail.price*detail.quantity}}</td>
                      </tr>
                    </table>
                  </td>
                  <td>{{ product.created_at | myDate }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      order: []
    };
  },
  mounted() {},
  created() {
    this.loadProducts();
  },
  methods: {
    loadProducts() {
      axios.get("/api/cart/order/history").then(response => {
        this.order = response.data.order;
      });
    }
  }
};
</script>

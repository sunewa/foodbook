<template>
  <!-- Page Content -->
  <div class="container">
    <!-- Page Heading -->
    <h1 class="my-4">
      Cart
      <small>All delicious foods you can get at your doorstep</small>
    </h1>

    <div class="row">
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 10%">#</th>
              <th style="width: 12%">Image</th>
              <th style="width: 38%">Product Name</th>
              <th style="width: 10%">Quantity</th>
              <th style="width: 5%">Price</th>
              <th style="width: 5%">Amount</th>
              <th style="width: 20%">
                <button class="btn btn-danger" v-on:click="deleteCart()">Empty Cart</button>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, key) in form.products" :key="product.id">
              <td>{{ key+1 }}</td>
              <td>
                <img :src="product.product.image_url_thumbs" alt="image" width="100px" />
              </td>
              <td>{{ product.product_name }}</td>
              <td>
                <input type="number" class="form-control" min="1" v-model="product.quantity" />
              </td>
              <td>{{ product.price_prefix }}{{ product.price }}</td>
              <td>{{ product.price_prefix }}{{ product.amount = product.quantity * product.price }}</td>
              <td>
                <button
                  class="btn btn-primary"
                  v-on:click="updateCart(product.product_id, product.quantity)"
                >Update</button>
                <button
                  class="btn btn-danger"
                  v-on:click="deleteCartProduct(product.id, product.product_id)"
                >Delete</button>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="text-align:right">Total</td>
              <td colspan="2">{{form.products.price_prefix }}{{ total }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row -->

    <form class="form-horizontal" @submit.prevent="submitCart">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Contact Details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" @submit.prevent="submitFeedback">
              <div class="card-body">
                <div class="form-group row">
                  <label for class="col-sm-2 col-form-label">Name*</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.name}"
                      id
                      placeholder="Name"
                      v-model="form.name"
                    />
                    <code v-if="errors.name">
                      {{
                      errors.name[0]
                      }}
                    </code>
                  </div>
                </div>

                <div class="form-group row">
                  <label for class="col-sm-2 col-form-label">Address*</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.address}"
                      id
                      placeholder="Name"
                      v-model="form.address"
                    />
                    <code v-if="errors.address">
                      {{
                      errors.address[0]
                      }}
                    </code>
                  </div>
                </div>

                <div class="form-group row">
                  <label for class="col-sm-2 col-form-label">Contact*</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.contact}"
                      id
                      placeholder="Name"
                      v-model="form.contact"
                    />
                    <code v-if="errors.contact">
                      {{
                      errors.contact[0]
                      }}
                    </code>
                  </div>
                </div>
                <div class="form-group row">
                  <label for class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input
                      type="email"
                      class="form-control"
                      id
                      placeholder="Email"
                      v-model="form.email"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-2 col-form-label">Message</label>
                  <div class="col-sm-10">
                    <textarea
                      class="form-control"
                      placeholder="Type your message..."
                      :class="{'is-invalid': errors.message}"
                      v-model="form.message"
                    ></textarea>
                    <code v-if="errors.message">
                      {{
                      errors.message[0]
                      }}
                    </code>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <!-- /.card-footer -->
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Card Details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">
              <div class="form-group row">
                <label for class="col-sm-2 col-form-label">Card Holder Name*</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.card_name}"
                    id
                    placeholder="Name"
                    v-model="form.card_name"
                  />
                  <code v-if="errors.card_name">
                    {{
                    errors.card_name[0]
                    }}
                  </code>
                </div>
              </div>
              <div class="form-group row">
                <label for class="col-sm-2 col-form-label">Card Number*</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.card_number}"
                    id
                    placeholder="Name"
                    v-model="form.card_number"
                  />
                  <code v-if="errors.card_number">
                    {{
                    errors.card_number[0]
                    }}
                  </code>
                </div>
              </div>

              <div class="form-group row">
                <label for class="col-sm-2 col-form-label">Expiry Date*</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.card_expiry_date}"
                    id
                    placeholder="Name"
                    v-model="form.card_expiry_date"
                  />
                  <code v-if="errors.card_expiry_date">
                    {{
                    errors.card_expiry_date[0]
                    }}
                  </code>
                </div>
              </div>

              <div class="form-group row">
                <label for class="col-sm-2 col-form-label">CCV*</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.card_ccv}"
                    id
                    placeholder="Name"
                    v-model="form.card_ccv"
                  />
                  <code v-if="errors.card_ccv">
                    {{
                    errors.card_ccv[0]
                    }}
                  </code>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-info float-right">Submit</button>
            </div>
            <!-- /.card-footer -->
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- /.container -->
</template>

<script>
export default {
  data() {
    return {
      form: {
        products: [],
        name: "",
        email: "",
        address: "",
        contact: "",
        message: "",
        amount: 0,
        card_name: "",
        card_number: "",
        card_expiry_date: "",
        card_ccv: ""
      },
      errors: []
    };
  },
  created() {
    this.loadCart();
    Fire.$on("loadCart", () => {
      this.loadCart();
    });
  },
  mounted() {
    console.log("Component mounted.");
  },
  computed: {
    total: function() {
      return this.form.products.reduce(function(total, item) {
        return total + item.amount;
      }, 0);
    }
  },
  methods: {
    loadCart() {
      axios.get("/api/cart").then(response => {
        this.form.products = response.data.cart;
      });
    },
    updateCart(product_id, quantity) {
      axios
        .put("/api/add-to-cart", { id: product_id, quantity: quantity })
        .then(response => {
          Toast.fire({
            icon: "success",
            title: "Added to cart"
          });
          Fire.$emit("loadCart");
        });
    },
    deleteCartProduct(id, product_id) {
      axios.delete("/api/cart/" + id + "/" + product_id).then(response => {
        Toast.fire({
          icon: "success",
          title: "Successfully Deleted"
        });
        Fire.$emit("loadCart");
      });
    },
    deleteCart() {
      axios.delete("/api/cart").then(response => {
        Toast.fire({
          icon: "success",
          title: "Successfully Deleted"
        });
        this.$router.push({ name: "home-product" });
      });
    },
    submitCart() {
      // Submit the form via a POST request
      axios
        .post("/api/cart", this.form)
        .then(({ data }) => {
          this.form = [];
          Toast.fire({
            icon: "success",
            title:
              "Successfully send. Please check email for further more details."
          });
          this.$router.push({ name: "home" });
        })
        .catch(err => {
          this.errors = err.response.data.errors;
        });
    }
  }
};
</script>

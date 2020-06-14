<template>
    <div class="card h-100">
          <router-link
                    :to="{
                        name: 'home-product-detail',
                        params: { slug: product.slug }
                    }"
                    >
            <img class="card-img-top" :src="product.image_url_thumbs" alt />
          </router-link>
          <div class="card-body">
            <h4 class="card-title">
              <router-link
                    :to="{
                        name: 'home-product-detail',
                        params: { slug: product.slug }
                    }"
                    >{{ product.title }}</router-link>
            </h4>
            <p
              class="card-text"
            >Price: {{ product.price_prefix }}{{ product.price }}</p>
            <p
              class="card-text"
            >{{ product.short_description }}</p>

            <a
                    class="btn btn-outline-primary"
                    v-for="tag in product.tags"
                    :key="tag.id"
                >
                    {{ tag.name }}
                </a>
          </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["product"],
    mounted() {
        console.log("Component mounted.");
    }
};
</script>

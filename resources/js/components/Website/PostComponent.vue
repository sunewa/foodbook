<template>
    <div class="card h-100">
          <router-link
                    :to="{
                        name: 'home-post-detail',
                        params: { slug: post.slug }
                    }"
                    >
            <img class="card-img-top" :src="post.image_url_thumbs" alt />
          </router-link>
          <div class="card-body">
            <h4 class="card-title">
              <router-link
                    :to="{
                        name: 'home-post-detail',
                        params: { slug: post.slug }
                    }"
                    >{{ post.title }}</router-link>
            </h4>
            <p
              class="card-text"
            >{{ post.short_description }}</p>

            <a
                    class="btn btn-outline-primary"
                    v-for="tag in post.tags"
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
    props: ["post"],
    mounted() {
        console.log("Component mounted.");
    }
};
</script>

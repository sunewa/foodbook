<template>
    <div>
        <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body flex-column align-items-start">
                <h3 class="mb-0">
                    <a class="text-dark" href="#">{{ post.title }}</a>
                </h3>
                <div class="mb-1 text-muted">{{ post.created_at }}</div>
                <p class="card-text mb-auto">
                    {{ post.short_description }}
                </p>
                <router-link
                    :to="{
                        name: 'home-post-detail',
                        params: { slug: post.slug }
                    }"
                    >Continue reading</router-link
                >
                <br />
                <a
                    class="btn btn-outline-primary"
                    v-for="tag in post.tags"
                    :key="tag.id"
                >
                    {{ tag.name }}
                </a>
            </div>
            <img
                class="card-img-right flex-auto d-none d-md-block"
                data-src="holder.js/200x250?theme=thumb"
                alt="Thumbnail [200x250]"
                style="width: 200px; height: 200px;"
                :src="post.image_url_thumbs"
                data-holder-rendered="true"
            />
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

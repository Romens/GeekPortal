<template>
    <MainLayout>
        <div class="container">
            <PostsCatalog />
        </div>
    </MainLayout>
</template>

<script setup lang="ts">
    import PostsCatalog from '@/components/posts/PostsCatalog.vue';
    import MainLayout from "@/layouts/MainLayout.vue";
</script>

<style scoped></style>

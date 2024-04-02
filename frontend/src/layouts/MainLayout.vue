<template>
    <div class="main-layout">
        <HeaderComponent></HeaderComponent>
        <div class="area">
            <slot></slot>
        </div>
        <FooterComponent></FooterComponent>
    </div>
</template>

<script setup lang="ts">
    import HeaderComponent from "@/components/HeaderComponent.vue";
    import FooterComponent from "@/components/FooterComponent.vue";
</script>

<style scoped>
    .area {
        padding-top: 4rem;
    }
</style>

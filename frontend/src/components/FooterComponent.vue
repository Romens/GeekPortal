<template>
    <footer>
        <div class="container text-center">
            <p>
                <a href="https://github.com/RomensTeam/CatalogBootstrap" target="_blank">Catalog Bootstrap</a>
                {{ (thisYear > 2024) ? ('2024 - ' + thisYear) : thisYear }}
            </p>
        </div>
    </footer>
</template>
<script setup lang="ts">
    import {computed} from "vue";

    const thisYear = computed(() => {return (new Date().getFullYear()); })
</script>

<style scoped>
</style>

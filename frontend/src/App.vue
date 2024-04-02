<script setup lang="ts">
import { RouterView } from 'vue-router';
import {useI18n} from "vue-i18n";

const t = useI18n()

</script>

<template>
    <div class="app">
        <slot></slot>
        <RouterView />
    </div>
</template>

<style scoped>

</style>

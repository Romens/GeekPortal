<template>
    <div class="action-area">
        <div class="action-item">
            <RouterLink class="action-button btn" to="/posts/create">{{ $t('post.create') }}</RouterLink>
        </div>
    </div>
</template>
<style scoped>
    .action-area {
        position: fixed;
        bottom: 100px;
        right: 50px;
    }
    .action-button,
    .action-button:hover {
        background-color: white;
        border: 5px solid rgb(var(--bs-dark-rgb));
        font-size: 2rem;
        border-radius: 0;
        font-weight: bold;
        text-transform: uppercase;
        color: rgb(var(--bs-dark-rgb));
        box-shadow: 5px 5px 5px  rgb(var(--bs-dark-rgb));
    }
    .action-button:hover {
        box-shadow: none;
    }
</style>

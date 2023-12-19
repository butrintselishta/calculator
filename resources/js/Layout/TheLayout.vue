<template>
    <div class="h-screen flex w-full items-center main px-4">
        <slot> </slot>
    </div>
</template>
<style scoped>
.main {
    background-image: url('/img/bg.jpg');
    background-size: cover;
    background-position: center;;
}
</style>

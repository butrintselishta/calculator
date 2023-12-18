<template>
    <TheLayout>
        <router-view />
    </TheLayout>
</template>

<script>
import TheLayout from './Layout/TheLayout.vue';
import Login from './Pages/Login.vue';
import Calculator from './Pages/Calculator.vue';

export default {
    name: 'App',
    components: {
        TheLayout,
        Login,
        Calculator,
    },
    data() {
    },
}
</script>


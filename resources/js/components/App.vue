<template>
    <div id="app">
        <Header />
        <div class="container">
            <router-view />
        </div>
        <div>
            <Footer />
        </div>
    </div>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
export default {
    name: "App",
    components: {
        Header,
        Footer,
    },
};
</script>

<style scoped>
#app {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
.container {
    flex: 1;
}
</style>

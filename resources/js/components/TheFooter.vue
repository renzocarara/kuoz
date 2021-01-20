<template>
    <v-footer class="py-0" dark color="blue-grey" app>
        <span>
            <a
                class="link"
                href="https://www.renzocarara.it/"
                target="_blank"
                rel="noopener noreferrer"
                >Renzo Carara - &copy; {{ new Date().getFullYear() }}
            </a></span
        >
    </v-footer>
</template>

<script>
export default {
    data() {
        return {};
    },
};
</script>

<style lang="css" scoped>
.link {
    text-decoration: none;
    color: white;
}
</style>
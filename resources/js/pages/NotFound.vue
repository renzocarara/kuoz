<template>
    <v-container class="my-5">
        <v-flex class="my-5">
            <v-card class="mx-auto">
                <v-img height="250" src="/images/error404.jpg"></v-img>
                <v-card-text class="pb-0">
                    <h1 class="text-center">404 Page Not Found</h1>
                    <br />
                    <h3 class="text-center">
                        Sorry, the page you are trying to get to never existed
                        in this reality, or has migrated to a parallel universe.
                        <br />
                        Try going back to home page and repeating your action.
                        Or, contact helpdesk for support.
                    </h3>
                </v-card-text>

                <hr class="my-3" />
                <v-card-actions>
                    <v-spacer />
                    <v-btn dark color="blue-grey" to="/dashboard"
                        >Back to dashboard</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-container>
</template>

<script>
export default {
    name: "NotFound",
};
</script>

<style lang="scss" scoped>
//
</style>

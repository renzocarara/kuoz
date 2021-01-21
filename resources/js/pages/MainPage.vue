<template>
    <div>
        <h1 class="text-center">All Quotes</h1>

        <div v-if="isLoading" class="view-centered">
            <v-progress-circular
                class="ml-7"
                indeterminate
                size="50"
                width="8"
                color="red"
            ></v-progress-circular>
            <p class="red--text text-h6">Reading data...</p>
        </div>
        <v-container class="d-flex flex-wrap justify-center">
            <v-card
                class="d-flex flex-column justify-space-between mx-3 my-3"
                width="240"
                v-for="quote in quotes"
                :key="quote.id"
            >
                <v-card-title class="pb-0 word-break-normal"
                    ><strong
                        >&ldquo;{{ quote.text }}&rdquo;</strong
                    ></v-card-title
                >
                <v-card-text
                    class="text-right text-subtitle-1 word-break-normal"
                    >--<strong> {{ quote.author }} </strong>--

                    <hr class="mt-3" />
                    <v-spacer />
                    <small>contributor: {{ username(quote.user_id) }}</small
                    ><br />
                    <small class=""
                        >inserted: {{ quote.created_at.substr(0, 10) }}</small
                    >
                </v-card-text>
            </v-card>
            <v-card v-if="noDataInDB"
                ><v-card-text>No quotes found in DB!</v-card-text></v-card
            >
        </v-container>
    </div>
</template>

<script>
export default {
    name: "MainPage",
    data() {
        return {
            quotes: [],
            users: [],
            isLoading: false, // circular progress flag

            noDataInDB: false, // no data found in DB flag
        };
    },
    mounted() {
        console.log("MainPage component mounted...");
        this.loadQuotes();
    },

    methods: {
        loadQuotes() {
            // DESCRIPTION:
            // read the data (all the quotes) from DB via axios API call

            console.log("loadQuotes() called..");

            this.isLoading = true;
            // read data from DB via api call
            axios({
                method: "GET",
                url: "/api/kuoz/quotes",
            })
                .then((response) => {
                    this.handleSuccess(response);
                })
                .catch((error) => {
                    this.handleError(error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        handleSuccess(response) {
            console.log("API CALL SUCCESS");
            console.log("response.data", response.data);
            //
            this.quotes = response.data[0];
            this.users = response.data[1];

            this.noDataInDB = !this.quotes.length;
        },
        handleError(error) {
            console.log("API CALL FAILED");
            console.log("error", error);
            alert("API call failed!");
        },

        username(user_id) {
            // DESCRIPTION:
            // get user name from user id

            // search id in the array containing the user list
            // return an array with the searched element, if not found return "undefined"
            let userName = this.users.filter((obj) => {
                return obj.id === user_id;
            });

            if (userName !== undefined) {
                userName = userName[0].name;
            } else {
                userName = "Not available";
            }

            return userName;
        },
    },
};
</script>

<style lang="css" scoped>
</style>

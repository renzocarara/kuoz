<template>
    <v-container>
        <div v-if="inProgress">
            <v-progress-circular
                indeterminate
                size="50"
                width="8"
                color="red"
            ></v-progress-circular>
            <p class="red--text text-h6">{{ progressMessage }}</p>
        </div>

        <v-form v-model="validity" ref="form">
            <h3 class="text-center">Add new Quote</h3>
            <v-card width="" class="mx-3 my-3">
                <v-card-text>
                    <!-- input field for quote text -->
                    <v-textarea
                        placeholder="Add a new quote here..."
                        v-model="text"
                        dense
                        filled
                        rows="2"
                        :rules="textRules"
                        counter="255"
                        color=""
                        background-color=""
                    ></v-textarea>
                    <!-- input field for quote author -->
                    <v-text-field
                        placeholder="Add the author"
                        v-model="author"
                        dense
                        filled
                        :rules="authorRules"
                        counter="50"
                        color=""
                        background-color=""
                        @keydown.enter.prevent="addQuote"
                    >
                        <!-- button to add the input -->
                        <template v-slot:append>
                            <v-icon
                                :disabled="!validity"
                                class="ml-2"
                                size="40"
                                color="green"
                                @click="addQuote"
                                >mdi-playlist-plus</v-icon
                            >
                        </template>
                    </v-text-field>
                </v-card-text>
            </v-card>
        </v-form>
    </v-container>
</template>

<script>
import {
    TEXT_MAX_CHARS,
    TEXT_MIN_CHARS,
    AUTHOR_MAX_CHARS,
    AUTHOR_MIN_CHARS,
} from "../const.js";

export default {
    data: () => ({
        progressMessage: "",
        inProgress: false, // flag for progress circle

        text: "", // text of quote
        author: "", // author of quote

        validity: false, // check form validity
        textRules: [
            (v) =>
                v.trim().length <= TEXT_MAX_CHARS ||
                "Max " + TEXT_MAX_CHARS + " characters",
            (v) =>
                v.trim().length >= TEXT_MIN_CHARS ||
                "Min " + TEXT_MIN_CHARS + " characters",
        ],
        authorRules: [
            (v) =>
                v.trim().length <= AUTHOR_MAX_CHARS ||
                "Max " + AUTHOR_MAX_CHARS + " characters",
            (v) =>
                v.trim().length >= AUTHOR_MIN_CHARS ||
                "Min " + AUTHOR_MIN_CHARS + " characters",
        ],
    }),

    methods: {
        addQuote() {
            // DESCRIPTION:
            // check input and, if OK, write data in DB via axios API call

            // remove unwanted blanks, trim blanks and replace multiple blank sequences with only one blank
            let text = this.text.trim().replace(/  +/g, " ");
            let author = this.author.trim().replace(/  +/g, " ");

            if (
                text.length >= TEXT_MIN_CHARS &&
                text.length <= TEXT_MAX_CHARS &&
                author.length >= AUTHOR_MIN_CHARS &&
                author.length <= AUTHOR_MAX_CHARS
            ) {
                this.inProgress = true;
                this.progressMessage = "Writing data...";
                // update the DB
                axios({
                    method: "POST",
                    url: "/api/kuoz/store",
                    headers: {
                        "content-type": "application/json",
                    },
                    params: {
                        text: text,
                        author: author,
                        user_id: this.$store.state.uid,
                    },
                })
                    .then((response) => {
                        this.handleSuccess(response);
                    })
                    .catch((error) => {
                        this.handleError(error);
                    })
                    .finally(() => {
                        this.inProgress = false;
                    });
            }

            // clear input fields
            this.text = "";
            this.author = "";
        },

        handleSuccess(response) {
            console.log(
                "API CALL SUCCESS addQuote response.data: ",
                response.data
            );

            // emit an event to let the parent component know that DB has been updated
            this.$emit("emitDbUpdated");
        },
        handleError(error) {
            console.log("API CALL FAILED addQuote() error: ", error);
            alert("API call failed!");
        },
    },
};
</script>
<style  scoped lang="scss">
.v-icon.mdi-playlist-plus:hover {
    transform: scale(1.2);
}
</style>
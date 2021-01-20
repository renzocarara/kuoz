<template>
    <div>
        <h1 class="text-center">Manage Quotes</h1>
        <!-- <h1>uid: {{ this.$store.state.uid }}</h1> -->
        <div v-if="inProgress" class="view-centered">
            <v-progress-circular
                indeterminate
                size="50"
                width="8"
                color="red"
            ></v-progress-circular>
            <p class="red--text text-h6">{{ progressMessage }}</p>
        </div>
        <!-- emitDbUpdated event: when a DB update occurs then reload data from DB -->
        <add-quote @emitDbUpdated="loadUserQuotes"></add-quote>

        <v-container>
            <h3 class="text-center">Your current Quotes</h3>
        </v-container>

        <v-container class="d-flex flex-wrap justify-center pt-0">
            <v-card
                width=""
                class="mx-3 my-3"
                v-for="(quote, index) in quotes"
                :key="index"
            >
                <v-card-title class="pb-0 word-break-normal">
                    <!-- render the span when no edit has begun or edit has begun but the element is not the one clicked -->
                    <!-- or the click was on the "author field" -->
                    <span
                        class="cursor-pointer"
                        v-if="
                            quoteId == null ||
                            quote.id != quoteId ||
                            fieldType != 'text'
                        "
                        @click="editQuote(index, 'text')"
                    >
                        <strong>&ldquo;{{ quote.text }}&rdquo;</strong>
                    </span>

                    <!-- textarea to edit the quote -->
                    <v-form v-else v-model="text_validity">
                        <v-textarea
                            ref="quoteText"
                            dense
                            counter="255"
                            v-model="quoteText"
                            :rules="textRules"
                            @keydown.enter="updateQuote"
                            @blur="updateQuote"
                        >
                            <!-- floppy disk icon to save data -->
                            <template v-slot:prepend-inner>
                                <v-icon
                                    @click="updateQuote"
                                    color="green"
                                    large
                                    :disabled="!text_validity"
                                    >mdi-content-save</v-icon
                                >
                            </template>
                        </v-textarea>
                    </v-form>
                </v-card-title>

                <v-card-text
                    class="text-right text-subtitle-1 word-break-normal"
                    ><span
                        class="cursor-pointer"
                        v-if="
                            quoteId == null ||
                            quote.id != quoteId ||
                            fieldType != 'author'
                        "
                        @click="editQuote(index, 'author')"
                        >-- {{ quote.author }} --</span
                    >

                    <!-- text-field to edit the author -->
                    <v-form v-else v-model="author_validity">
                        <v-text-field
                            ref="quoteAuthor"
                            dense
                            counter="50"
                            v-model="quoteAuthor"
                            :rules="authorRules"
                            @keydown.enter="updateQuote"
                            @blur="updateQuote"
                        >
                            <!-- floppy disk icon to save data -->
                            <template v-slot:prepend-inner>
                                <v-icon
                                    @click="updateQuote"
                                    color="green"
                                    large
                                    :disabled="!author_validity"
                                    >mdi-content-save</v-icon
                                >
                            </template>
                        </v-text-field>
                    </v-form>
                </v-card-text>

                <v-btn
                    icon
                    class="mx-2 mb-2"
                    color="blue-grey lighten-4"
                    @click="showDialog(quote.id)"
                >
                    <v-icon dark> mdi-trash-can-outline </v-icon>
                </v-btn>

                <!-- confirmation dialog - Delete Quote? -->
                <!-- @emitConfirmed="deleteQuote(quote.id)" -->
                <confirmation-dialog
                    v-if="deleteQuoteDialog"
                    @emitConfirmed="deleteQuote"
                    @emitCancelled="deleteQuoteDialog = false"
                    dialogTitleLabel="Warning"
                    dialogTitleText="Delete Quote"
                    dialogMessage="You're are gonna delete this quote from the Data Base! Do you really want to proceed?"
                    dialogConfirmBtn="DELETE"
                    dialogCancelBtn="CANCEL"
                />
            </v-card>
            <v-card v-if="noDataInDB"
                ><v-card-text>No quotes found in DB!</v-card-text></v-card
            >
        </v-container>
    </div>
</template>

<script>
import AddQuote from "../components/AddQuote";
import ConfirmationDialog from "../components/ConfirmationDialog";

import {
    TEXT_MAX_CHARS,
    TEXT_MIN_CHARS,
    AUTHOR_MAX_CHARS,
    AUTHOR_MIN_CHARS,
} from "../const.js";

export default {
    name: "ManagePage",
    components: {
        AddQuote,
        ConfirmationDialog,
    },
    data() {
        return {
            quotes: [], // quotes read from DB
            noDataInDB: false, // true if DB reading returns no data

            progressMessage: "",
            inProgress: false, // flag for progress circle

            quoteId: null, // id of quote to be edited
            quoteText: "", // quote text to be edited
            quoteAuthor: "", // quote author to be edited
            index: 0, // index of the quote to be edited (the element in quotes[] array)
            fieldType: "", // type of field beeing edited ("author" or "text")

            deleteQuoteDialog: false, // flag to enable confirmation dialog
            id_to_be_deleted: 0, // id of quote to de deleted

            text_validity: false, // check validity
            author_validity: false, // check validity
            textRules: [
                (v) =>
                    v.trim().length <= TEXT_MAX_CHARS || "Max 255 characters",
                (v) => v.trim().length >= TEXT_MIN_CHARS || "Min 3 characters",
            ],
            authorRules: [
                (v) =>
                    v.trim().length <= AUTHOR_MAX_CHARS || "Max 50 characters",
                (v) =>
                    v.trim().length >= AUTHOR_MIN_CHARS || "Min 2 characters",
            ],
        };
    },
    mounted() {
        console.log("ManagePage component mounted...");
        this.loadUserQuotes();
    },
    methods: {
        loadUserQuotes() {
            // DESCRIPTION:
            // read the data from DB via axios API call
            // only the data associated to the logged user are read from DB

            console.log("LoadUserQuotes() called...");

            this.inProgress = true;
            this.progressMessage = "Reading data...";

            // read data from DB via API call
            axios({
                method: "POST",
                url: "/api/kuoz/quotes/" + this.$store.state.uid,
            })
                .then((response) => {
                    console.log("loadUserQuotes API CALL SUCCESS");
                    console.log(
                        "loadUserQuotes() response.data: ",
                        response.data
                    );
                    // save received data in local variable
                    this.quotes = response.data;
                    this.noDataInDB = !this.quotes.length;
                })
                .catch((error) => {
                    this.handleError(error);
                })
                .finally(() => {
                    this.inProgress = false;
                });
        },

        showDialog(id) {
            this.deleteQuoteDialog = true;
            this.id_to_be_deleted = id;
            console.log("id al click su bidone: ", id);
        },

        deleteQuote() {
            // DESCRIPTION:
            // allow the deletion of a quote

            // hide confirmation dialog
            this.deleteQuoteDialog = false;

            console.log("deleteQuotes called..");
            console.log("id: ", this.id_to_be_deleted);

            this.inProgress = true;
            this.progressMessage = "Deleting data...";

            // delete data via API call
            axios({
                method: "DELETE",
                url: "/api/kuoz/delete/" + this.id_to_be_deleted,
            })
                .then((response) => {
                    //  reload data after deletion
                    this.loadUserQuotes();
                })
                .catch((error) => {
                    this.handleError(error);
                })
                .finally(() => {
                    this.inProgress = false;
                });
        },

        editQuote(index, fieldType) {
            // DESCRIPTION:
            // show an input field (v-text-field or v-textarea) instead of a span
            // to allow the user to modify data

            console.log("editQuote called..");
            console.log("quoteId", this.quotes[index].id);

            // make the textarea appear and the span disappear
            this.quoteId = this.quotes[index].id;

            this.fieldType = fieldType; // type of field selected for edit ("text" or "author")

            this.index = index; // index of the element being edited
            // copy the current values of span element before start edit the input element
            this.quoteText = this.quotes[index].text;
            this.quoteAuthor = this.quotes[index].author;

            // NOTA: at this moment v-text input is not yet rendered, so to set focus on it I need to wait
            // when the element actually exists in the DOM, so I use the "nextTick()" that listen for the next update of DOM
            // NOTE:
            // the ref in this case is an array (because it is defined in a v-for loop), so to access it I use the
            // square notation, with "0" index, the array will have always only 1 element, because I render the element
            // having the ref attribute when I enter the v-else branch, this happens only 1 time during all the v-for loop
            // console.log("this.$refs", this.$refs); // list of elements with a ref attribute
            // console.log("this.$refs.quoteText[0]", this.$refs.quoteText[0]);

            // set focus on the input field to be edited
            if (fieldType == "text") {
                this.$nextTick(() => {
                    this.$refs.quoteText[0].focus();
                });
            } else {
                // fieldType="author"
                this.$nextTick(() => {
                    this.$refs.quoteAuthor[0].focus();
                });
            }
        },

        updateQuote() {
            // DESCRIPTION:
            // it is called in three different cases while the user is editing a field:
            // user presses ENTER, user clicks floppy icon or the input field looses focus
            // take the modified data, makes some validity checks and, if ok,
            // update the DB via an axios API call

            console.log("updateQuote() called!");
            console.log("quoteText:", this.quoteText);
            console.log("quoteAuthor:", this.quoteAuthor);

            // remove unwanted blanks, trim blanks and replace multiple blank sequences with only one blank
            let text = this.quoteText.trim().replace(/  +/g, " ");
            let author = this.quoteAuthor.trim().replace(/  +/g, " ");

            if (
                text.length >= TEXT_MIN_CHARS &&
                text.length <= TEXT_MAX_CHARS &&
                author.length >= AUTHOR_MIN_CHARS &&
                author.length <= AUTHOR_MAX_CHARS
            ) {
                this.inProgress = true;
                this.progressMessage = "Updating data...";

                // update DB
                axios({
                    method: "PUT",
                    url: "/api/kuoz/update/" + this.quoteId,
                    headers: {
                        "content-type": "application/json",
                    },
                    params: {
                        text: text,
                        author: author,
                    },
                })
                    .then((response) => {
                        //  reload data after update, to show user the last data changes
                        this.loadUserQuotes();
                    })
                    .catch((error) => {
                        this.handleError(error);
                    })
                    .finally(() => {
                        this.inProgress = false;
                    });

                // set the span with modified text before to make it appears again
                this.quotes[this.index].text = text;
                this.quotes[this.index].author = author;
            }

            // make the textarea disappear and the span reappear
            this.quoteId = null;
        },

        handleError(error) {
            // DESCRIPTION:
            // Display error when an axios API cal fails
            console.log("API CALL FAILED");
            console.log("error: ", error);
            alert("API call failed!");
        },
    },
};
</script>

<style lang="scss" scoped>
.v-btn i.mdi-trash-can-outline:hover {
    transform: scale(1.2);
    color: red;
}
</style>
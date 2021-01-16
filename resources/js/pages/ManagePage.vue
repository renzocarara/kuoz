<template>
  <div>
    <h1 class="text-center">Manage Quotes</h1>
    <h1>uid: {{ this.$store.state.uid }}</h1>
    <div v-if="isLoading">
      <v-progress-circular indeterminate color="deep-red"></v-progress-circular>
      <p class="purple--text">Reading data...</p>
    </div>
    <!-- emitDbUpdated event: when a DB update occurs then reload data from DB -->
    <add-quote @emitDbUpdated="loadUserQuotes"></add-quote>

    <v-container>
      <h3>Your current Quotes</h3>
    </v-container>

    <v-container class="d-flex flex-wrap justify-center">
      <v-card
        width=""
        class="mx-3 my-3"
        v-for="(quote, index) in quotes"
        :key="index"
      >
        <v-card-title class="pb-0">
          <span
            v-if="quoteId == null || quote.id != quoteId"
            @click="editQuoteText(index)"
          >
            <strong>&ldquo;{{ quote.text }}&rdquo;</strong>
          </span>

          <!-- text-area to edit the quote -->
          <v-form v-else v-model="validity">
            <v-textarea
              ref="quoteEdit"
              dense
              counter="255"
              v-model="quoteText"
              :rules="textRules"
              @keydown.enter="updateQuote"
              @blur="updateQuote"
            >
              <template v-slot:prepend-inner>
                <v-icon
                  @click="updateQuote"
                  color="green"
                  large
                  :disabled="!validity"
                  >mdi-content-save</v-icon
                >
              </template>
            </v-textarea>
          </v-form>
        </v-card-title>

        <!-- **************************************************************** -->
        <!-- **************************************************************** -->
        <!-- **************************************************************** -->
        <!-- **************************************************************** -->
        <!-- **************************************************************** -->
        <!-- all'interno di card-text inserire 1 span con a seguire un form con dentro un text-field -->

        <v-card-text class="text-right text-subtitle-1"
          >-- {{ quote.author }} --</v-card-text
        >

        <v-btn
          icon
          class="mx-2 mb-2"
          dark
          small
          color="blue-grey lighten-4"
          @click="deleteQuote(quote.id)"
        >
          <v-icon dark> mdi-trash-can-outline </v-icon>
        </v-btn>
      </v-card>
      <v-card v-if="quotes.length == 0"
        ><v-card-text>No quotes found in DB!</v-card-text></v-card
      >
    </v-container>
  </div>
</template>

<script>
import AddQuote from "../components/AddQuote";

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
  },
  data() {
    return {
      quotes: [], // quotes read from DB
      isLoading: true, // flag for progress circle

      quoteId: null, // id of quote to be edited
      quoteText: "", // quote text to be edited
      quoteAuthor: "", // quote author to be edited
      index: 0, // index of the quote to be edited (the element in quotes[] array)

      validity: false, // check validity
      textRules: [
        (v) => v.trim().length <= TEXT_MAX_CHARS || "Max 255 characters",
        (v) => v.trim().length >= TEXT_MIN_CHARS || "Min 3 characters",
      ],
      authorRules: [
        (v) => v.trim().length <= AUTHOR_MAX_CHARS || "Max 50 characters",
        (v) => v.trim().length >= AUTHOR_MIN_CHARS || "Min 2 characters",
      ],
    };
  },
  mounted() {
    console.log("ManagePage component mounted...");
    this.loadUserQuotes();
  },
  methods: {
    loadUserQuotes() {
      console.log("LoadUserQuotes() called...");
      // read data from DB via API call
      axios({
        method: "POST",
        url: "/api/kuoz/quotes/" + this.$store.state.uid,
      })
        .then((response) => {
          console.log("loadUserQuotes API CALL SUCCESS");
          console.log("loadUserQuotes() response.data: ", response.data);
          // save received data in local variable
          this.quotes = response.data;
        })
        .catch((error) => {
          this.handleError(error);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    deleteQuote(id) {
      // this method receives the id of the quote to be deleted
      console.log("deleteQuotes called..");
      console.log("id: ", id);

      // delete data via API call
      axios({
        method: "DELETE",
        url: "/api/kuoz/delete/" + id,
      })
        .then((response) => {
          //  reload data after deletion
          this.loadUserQuotes();
        })
        .catch((error) => {
          this.handleError(error);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    editQuoteText(index) {
      console.log("editQuoteText called..");
      console.log("quoteId", this.quotes[index].id);

      // DESCRIPTION:
      // show a textarea to allow the user to modify the quote

      // make the textarea appear and the span disappear
      this.quoteId = this.quotes[index].id;

      this.index = index; // index of the element being edited
      // copy the current values of span element before start edit the input element
      this.quoteText = this.quotes[index].text;
      this.quoteAuthor = this.quotes[index].author;

      // NOTA: qui ancora il v-text-field non è stato renderizzato, per cui per settare il focus devo aspettare
      // che  l'elemento esista nel DOM, quindi uso la "nextTick()" che aspetta il prossimo aggiornamento del DOM
      // NOTE:
      // setto il focus sul v-text-field del task da editare
      // console.log("this.$refs", this.$refs); // elenco degli elementi che hanno un attributo "ref" associato
      // console.log("this.$refs.quoteEdit[0]", this.$refs.quoteEdit[0]);
      // il ref "textEdit" è un array (perchè definito in un loop v-for), per cui per accederci devo usare la
      // square notation, con indice "0", l'array avrà sempre 1 solo elemento, perchè renderizzo l'elemento
      // che ha ref="quoteEdit" quando entro nel v-else, e ciò accade solo 1 volta all'interno di tutto il loop v-for
      this.$nextTick(() => {
        this.$refs.quoteEdit[0].focus();
      });
    },

    updateQuote() {
      // DESCRIPTION:
      // it is called in three different cases while the user is editing the text or the author:
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
            //  reload data after update
            this.loadUserQuotes();
          })
          .catch((error) => {
            this.handleError(error);
          })
          .finally(() => {
            this.isLoading = false;
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
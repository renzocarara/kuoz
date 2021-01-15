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
        v-for="quote in quotes"
        :key="quote.id"
      >
        <v-card-title class="pb-0"
          ><strong>&ldquo;{{ quote.text }}&rdquo;</strong></v-card-title
        >
        <v-card-text class="text-right text-h6"
          >-- {{ quote.author }} &hyphen;&hyphen;</v-card-text
        >

        <v-btn
          class="edit-btn mx-2 mb-2"
          rounded
          dark
          small
          color="blue-grey lighten-4"
          @click="editQuote"
        >
          <v-icon dark> mdi-pencil </v-icon>
        </v-btn>

        <v-btn
          class="delete-btn mx-2 mb-2"
          rounded
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
export default {
  name: "ManagePage",
  components: {
    AddQuote,
  },
  data() {
    return {
      quotes: [],
      isLoading: true,
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
          //   emit an event to advice the deletion has completed successfully
          this.$emit("emitQuoteDeleted");
        })
        .catch((error) => {
          this.handleError(error);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    editQuote() {
      console.log("editQuotes called..");
    },

    handleError(error) {
      console.log("API CALL FAILED");
      console.log("error: ", error);
      alert("API call failed!");
    },
  },
};
</script>

<style lang="scss" scoped>
.v-btn i:hover {
  transform: scale(1.2);
}
.delete-btn:hover {
  color: red;
}
.edit-btn:hover {
  color: blue;
}
</style>
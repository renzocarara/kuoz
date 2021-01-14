<template>
  <div>
    <p>
      ...qui appare un elenco delle quotes che appartengono all'utente loggato.
      L'utente dovrà poter aggiungere, modificare o cancellare una quote.
    </p>

    <h1>Your Quotes</h1>
    <h1>user_id: {{ this.$store.state.uid }}</h1>

    <div v-if="isLoading">
      <v-progress-circular indeterminate color="deep-red"></v-progress-circular>
      <p class="purple--text">Reading data...</p>
    </div>
    <v-container>
      <!-- when a DB update occurs then reload data from DB -->
      <add-quote @emitDbUpdated="loadUserQuotes"></add-quote>
    </v-container>
    <v-container class="d-flex flex-wrap justify-center">
      <v-card
        width="200"
        class="mx-3 my-3"
        v-for="quote in quotes"
        :key="quote.id"
      >
        <v-card-title
          >id: {{ quote.id }}. author:{{ quote.author }}</v-card-title
        >
        <v-card-text>{{ quote.text }}</v-card-text>
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
      console.log("loadUserQuotes API CALL SUCCESS");
      console.log("response.data: ", response.data);
      //
      this.quotes = response.data;
    },
    handleError(error) {
      console.log("API CALL FAILED");
      console.log("loadUserQuotes() error: ", error);
      alert("API call failed!");
    },
  },
};
</script>

<style>
</style>
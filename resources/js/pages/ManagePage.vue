<template>
  <div>
    <p>
      ...qui appare un elenco delle quotes che appartengono all'utente loggato.
      L'utente dovrà poter aggiungere, modificare o cancellare una quote.
    </p>

    <h1>Your Quotes</h1>
    <h1>user_id: {{ uid }}</h1>

    <div v-if="isLoading">
      <v-progress-circular indeterminate color="deep-red"></v-progress-circular>
      <p class="purple--text">Reading data...</p>
    </div>
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
    </v-container>
  </div>
</template>

<script>
export default {
  name: "ManagePage",
  props: ["uid"],
  data() {
    return {
      quotes: [],
      isLoading: true,
    };
  },
  mounted() {
    console.log("loadYourQuotes() called...");
    this.loadYourQuotes();
  },
  methods: {
    loadYourQuotes() {
      // leggo i dati via api call
      axios({
        method: "GET",
        url: "/api/quote/quotes_per_UID/" + this.uid,
        // url: "/api/quote/quotes_per_UID",
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
      console.log("response.data: ", response.data);
      //
      this.quotes = response.data; // no pagination
      //   this.quotes = response.data.data; // pagination
    },
    handleError(error) {
      console.log("API CALL FAILED");
      console.log("error: ", error);
      alert("API call failed!");
    },
  },
};
</script>

<style>
</style>
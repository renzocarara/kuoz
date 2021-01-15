<template>
  <div>
    <h1 class="text-center">All Quotes</h1>

    <div v-if="isLoading">
      <v-progress-circular indeterminate color="deep-red"></v-progress-circular>
      <p class="purple--text">Reading data...</p>
    </div>
    <v-container class="d-flex flex-wrap justify-center">
      <v-card
        width="240"
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
      </v-card>
      <v-card v-if="quotes.length == 0"
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
      isLoading: true,
    };
  },
  mounted() {
    console.log("MainPage component mounted...");
    this.loadQuotes();
  },
  methods: {
    loadQuotes() {
      console.log("loadQuotes() called..");
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
      this.quotes = response.data;
    },
    handleError(error) {
      console.log("API CALL FAILED");
      console.log("error", error);
      alert("API call failed!");
    },
  },
};
</script>

<style lang="css" scoped>
</style>

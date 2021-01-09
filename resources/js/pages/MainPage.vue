<template>
  <div>
    <h1 class="text-center">LavQuotes</h1>

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
  name: "MainPage",
  data() {
    return {
      quotes: [],
      isLoading: true,
    };
  },
  mounted() {
    console.log("loadQuotes() called...");
    this.loadQuotes();
  },
  methods: {
    loadQuotes() {
      // leggo i dati via api call
      axios({
        method: "GET",
        url: "/api/quotes", // API locale all'interno di questa APP
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
      //   this.quotes = response.data; // no pagination
      this.quotes = response.data.data; // pagination

      // estrarre i dati di paginazione da response.data
      // current_page: 1
      // data: Array(3)
      // first_page_url: "http://localhost:8000/api/quotes?page=1"
      // from: 1
      // last_page: 5
      // last_page_url: "http://localhost:8000/api/quotes?page=5"
      // links: Array(7)
      // next_page_url: "http://localhost:8000/api/quotes?page=2"
      // path: "http://localhost:8000/api/quotes"
      // per_page: 3
      // prev_page_url: null
      // to: 3
      // total: 15
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

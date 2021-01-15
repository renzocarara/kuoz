<template>
  <v-container>
    <v-form v-model="validity" ref="form">
      <h3>Add new Quote</h3>
      <v-card width="" class="mx-3 my-3">
        <v-card-text>
          <v-textarea
            placeholder="Add a new quote here..."
            id="text-input"
            v-model="text"
            outlined
            rows="2"
            :rules="textRules"
            counter="255"
            color=""
            background-color=""
          ></v-textarea>

          <v-text-field
            placeholder="Add the author"
            id="author-input"
            v-model="author"
            outlined
            :rules="authorRules"
            counter="50"
            color=""
            background-color=""
            @keydown.enter.prevent="addQuote"
          >
          </v-text-field>

          <v-btn
            class="white--text"
            small
            rounded
            :disabled="!validity"
            color="blue-grey"
            @click="addQuote"
          >
            ADD
          </v-btn>
        </v-card-text>
      </v-card>
    </v-form>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    text: "", // text of quote
    author: "", // author of quote

    validity: false, // check form validity
    textRules: [
      (v) => v.trim().length <= 255 || "Max 255 characters",
      (v) => v.trim().length >= 3 || "Min 3 characters",
    ],
    authorRules: [
      (v) => v.trim().length <= 50 || "Max 50 characters",
      (v) => v.trim().length >= 2 || "Min 2 characters",
    ],
  }),

  methods: {
    addQuote() {
      if (this.text.trim() !== "" && this.author.trim() !== "") {
        // update the DB
        axios({
          method: "POST",
          url: "/api/kuoz/store",
          headers: {
            "content-type": "application/json",
          },
          params: {
            text: this.text,
            author: this.author,
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
            this.isLoading = false;
          });
      }

      // clear input fields
      this.text = "";
      this.author = "";
    },

    handleSuccess(response) {
      console.log("addQuote API CALL SUCCESS");
      console.log("addQuote response.data: ", response.data);

      // emit an event to let the parent component know that DB has been updated
      this.$emit("emitDbUpdated");
    },
    handleError(error) {
      console.log("addQuote API CALL FAILED");
      console.log("addQuote() error: ", error);
      alert("API call failed!");
    },
  },
};
</script>

<style>
</style>
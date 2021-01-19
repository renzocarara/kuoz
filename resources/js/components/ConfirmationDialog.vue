<template>
  <!-- confirmation dialog -->
  <v-dialog v-model="dialogVisibility" max-width="290" persistent>
    <v-card>
      <v-card-title class="headline"
        >{{ dialogTitleLabel }}: <br />
        {{ dialogTitleText }}</v-card-title
      >

      <v-card-text>{{ dialogMessage }}</v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue-grey" dark @click="confirm">
          {{ dialogConfirmBtn }}
        </v-btn>
        <v-btn color="blue-grey" dark @click="cancel">
          {{ dialogCancelBtn }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: [
    "dialogTitleLabel",
    "dialogTitleText",
    "dialogMessage",
    "dialogConfirmBtn",
    "dialogCancelBtn",
  ],
  data: () => ({
    // show/hide dialog window
    dialogVisibility: true,
  }),
  methods: {
    confirm() {
      this.dialogVisibility = false;
      // emit an event to advice that the use confirmed
      this.$emit("emitConfirmed");
    },
    cancel() {
      this.dialogVisibility = false;
      // emit an event to advice that the user cancelled
      this.$emit("emitCancelled");
    },
  },
};
</script>
<style lang="scss" scoped>
</style>


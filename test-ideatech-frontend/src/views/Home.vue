<template>
  <section class="page-home">
    <v-card
        max-width="400"
        class="mx-auto"
    >
      <v-container>
        <v-row dense>
          <v-col cols="12">
            <v-card
                href="/list-authors"
                variant="outlined"
                color="purple">
              <v-card-title class="text-h5">View Authors</v-card-title>

              <v-card-subtitle>List all authors.</v-card-subtitle>

              <v-card-actions>
                <v-btn variant="text">
                  View
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>

          <v-col cols="12">
            <v-card
                href="/list-books"
                variant="outlined"
                color="purple">
              <v-card-title class="text-h5">View Books</v-card-title>

              <v-card-subtitle>List all books.</v-card-subtitle>

              <v-card-actions>
                <v-btn variant="text">
                  View
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>

          <v-col cols="12">
            <v-card
                href="/author-registration"
                variant="outlined"
                color="purple">
              <v-card-title class="text-h5">Register new authors</v-card-title>

              <v-card-subtitle>Register new author.</v-card-subtitle>

              <v-card-actions>
                <v-btn variant="text">
                  Register
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>

          <v-col cols="12">
            <v-card
                href="/book-registration"
                variant="outlined"
                color="purple">
              <v-card-title class="text-h5">Register new book</v-card-title>

              <v-card-subtitle>Register new book.</v-card-subtitle>

              <v-card-actions>
                <v-btn variant="text">
                  Register
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </section>
</template>

<script setup lang="ts">

</script>

<style scoped>

</style>

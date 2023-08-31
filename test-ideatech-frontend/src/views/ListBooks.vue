<template>
  <section class="page-list-books d-flex flex-column">
    <transition name="fade" mode="out-in">
      <v-alert
          v-show="alert.show"
          color="purple"
          variant="outlined"
          icon="$success"
          :title="alert.title"
          :text="alert.message"
      ></v-alert>
    </transition>

    <h2 :class="{'mb-10': !route.query.authorId}"
        class="ma-auto mt-10">Books</h2>
    <h2
        v-show="route.query.authorId"
        class="ma-auto mb-10 mt-10">
      {{ books[0]?.author.firstName }} {{ books[0]?.author.lastName }}
    </h2>

    <div class="list-books d-flex flex-wrap">
      <v-card
          class="mr-5 mb-5"
          width="300"
          variant="outlined"
          fill-height
          v-for="book in books"
          :key="book.id">

        <v-card-item>
          <div>

            <div class="text-h6 mb-1">{{ book.title }}</div>

            <div class="text-caption mt-5 overflow-y-auto">
              <p class="mb-1">Synopsis:</p>
              {{ book.synopsis }}
            </div>
          </div>
        </v-card-item>

        <v-card-actions class="d-flex justify-space-between">
          <v-btn
              @click="book.reveal = true"
              variant="outlined">
            Details
          </v-btn>

          <v-btn
              @click="deleteBook(book.id)"
              icon="fas fa-trash">
          </v-btn>
        </v-card-actions>

        <v-expand-transition>
          <v-card
              v-if="book.reveal"
              class="v-card--reveal"
              style="height: 100%;">

            <v-card-text class="pb-0">
              <p>Author: <span>{{ book.author.firstName }} {{ book.author.lastName }}</span></p>
              <p>Gender: <span>{{ book.gender }}</span></p>
              <p>Publication Year: <span>{{ book.publicationYear }}</span></p>
            </v-card-text>

            <v-card-actions class="pt-0">
              <v-btn
                  variant="text"
                  color="teal-accent-4"
                  @click="book.reveal = false"
              >
                Close
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-expand-transition>
      </v-card>

    </div>
  </section>
</template>

<script setup lang="ts">
import {computed, onMounted, reactive} from "vue";
import {useAuthorStore} from "@/store/authorStore.ts";
import {useRoute} from "vue-router";

const authorStore = useAuthorStore()
const route = useRoute()

const books = computed(() => authorStore.getBooks)
const alert = reactive({
  show: false,
  title: '',
  message: ''
})
const deleteBook = (bookId: string) => {
  authorStore.deleteBook(bookId)
      .then(() => {
        alert.title = "Deleted"
        alert.message = "Book deleted with success!"
        alert.show = true

        setTimeout(() => {alert.show = false}, 3000)
      })
}

onMounted(() => {
  if (route.query?.authorId) {
    authorStore.fetchBooksFromAuthor(route.query.authorId.toString())
  } else {
    authorStore.fetchBooks()
  }
})



</script>

<style scoped>
.page-list-books {
  .fade-enter-active, .fade-leave-active {
    transition: opacity 1s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }

  .v-card--reveal {
    bottom: 0;
    opacity: 1 !important;
    position: absolute;
    width: 100%;
  }
}
</style>

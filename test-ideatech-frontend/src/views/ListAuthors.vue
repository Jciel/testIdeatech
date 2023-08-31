<template>
  <section class="page-list-authors d-flex flex-column">
    <H2 class="ma-auto mb-10 mt-10">Authors</H2>

    <div class="list-authors d-flex flex-wrap">
      <v-card
          class="mr-5 mb-5"
          width="300"
          variant="outlined"
          fill-height
          v-for="author in authors"
          :key="author.id">

        <v-card-item>
          <div>
            <div class="text-overline mb-1">{{ author.lastName }}</div>

            <div class="text-h6 mb-1">{{ author.firstName }}</div>

            <div class="text-caption mt-5 overflow-y-auto">
              {{ author.biography }}
            </div>
          </div>
        </v-card-item>

        <v-card-actions>
          <v-btn
              @click="viewAuthorBooks(author.id)"
              variant="outlined">
            Books
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>
  </section>
</template>

<script setup lang="ts">
import {useAuthorStore} from "@/store/authorStore.ts";
import {computed, onMounted} from "vue";
import {useRouter} from "vue-router";

const authorStore = useAuthorStore()
const router = useRouter()

const authors = computed(() => authorStore.getAuthors)
onMounted(() => { authorStore.fetchAuthors() })

const viewAuthorBooks = (authorId: string) => {
  router.push({ path: '/list-books', query: { authorId: authorId } })
}

</script>

<style scoped>

</style>

<template>
  <section class="page-books-registration d-flex flex-column">
    <v-card
        variant="outlined"
        class="px-6 py-8 align-center align-self-center"
        max-width="680"
        width="680"
        title="Book Registration">

      <v-form
          v-model="formControls.form"
          @submit.prevent="onSubmit">

        <v-text-field
            v-model="data.title"
            :rules="[rules.required]"
            label="Title"
            variant="outlined"
            color="primary" />

        <v-text-field
            v-model="data.gender"
            :rules="[rules.required]"
            label="Gender"
            variant="outlined"
            color="primary" />

        <v-text-field
            v-model="data.cover"
            :rules="[rules.required]"
            label="Cover"
            variant="outlined"
            color="primary" />

        <v-text-field
            v-model="data.publicationYear"
            :rules="[rules.required]"
            type="date"
            label="Publication Year"
            variant="outlined"
            color="primary" />

        <v-textarea
            v-model="data.synopsis"
            :rules="[rules.required]"
            label="Synopsis"
            variant="outlined"
            color="primary" />

        <v-autocomplete
            :rules="[rules.required]"
            v-model="selectAuthor"
            v-model:search="searchAuthor"
            :items="items"
            :loading="formControls.searchLoading"
            label="Author"
            item-title="name"
            variant="outlined"
            hide-no-data
            hide-details
            return-object />

        <v-btn
            :disabled="!formControls.form"
            :loading="formControls.loading"
            block
            class="mt-10"
            color="primary"
            size="large"
            type="submit"
            variant="outlined">
          Register
        </v-btn>
      </v-form>
    </v-card>
  </section>
</template>

<script setup lang="ts">
import {useAuthorStore} from "@/store/authorStore.ts";
import {computed, onMounted, reactive, ref, watch} from "vue";
import {Author, Book} from "@/types.ts";

const authorStore = useAuthorStore()
const authors = ref([])
const selectAuthor = ref({ name: '', id: '' })
const searchAuthor = ref('')
const formControls = reactive({
  form: false,
  loading: false,
  searchLoading: false,
  search: null,
  select: null,
})
const data = reactive<Book>({
  id: '',
  title: '',
  gender: '',
  cover: '',
  publicationYear: new Date(),
  synopsis: '',
  author_id: '',
  author: null
})

const rules = {
  required: (value: string) => !!value || 'Field is required',
}

const items = computed(() => authors.value.map((author: Author) => {
  return {
    'name': `${author?.firstName} ${author?.lastName}`,
    'id': author?.id
  }
}))

watch(searchAuthor, () => {
  formControls.searchLoading = !formControls.searchLoading
  authorStore.searchAuthor(searchAuthor.value).then(res => {
    authors.value = res
    formControls.searchLoading = !formControls.searchLoading
  })
})

onMounted(() => authorStore.fetchAuthors())

const onSubmit = () => {
  data.author_id = selectAuthor.value.id
  formControls.loading = true
  authorStore.registerBook(data)
      .then(() => {
        formControls.loading = false
      }).catch((err) => {
        console.log('err: ', err)
        throw err
      })
}
</script>

<style scoped>

</style>

<template>
  <section class="page-author-registration d-flex flex-column">
    <v-card
        variant="outlined"
        class="px-6 py-8 align-center align-self-center"
        max-width="680"
        width="680"
        title="Author Registration">

      <v-form
          v-model="formControls.form"
          @submit.prevent="onSubmit">

        <v-text-field
            v-model="data.firstName"
            :rules="[rules.required]"
            label="First Name"
            variant="outlined"
            color="primary" />

        <v-text-field
            v-model="data.lastName"
            :rules="[rules.required]"
            label="Last Name"
            variant="outlined"
            color="primary" />

        <v-text-field
            v-model="data.country"
            :rules="[rules.required]"
            label="Country"
            variant="outlined"
            color="primary" />

        <v-text-field
            v-model="data.birthday"
            :rules="[rules.required]"
            type="date"
            label="Birthday"
            variant="outlined"
            color="primary" />

        <v-textarea
            v-model="data.biography"
            :rules="[rules.required]"
            label="Biography"
            variant="outlined"
            color="primary" />

        <v-btn
            :disabled="!formControls.form"
            :loading="formControls.loading"
            block
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

import {reactive} from "vue";
import {Author} from "@/types.ts";
import {useAuthorStore} from "@/store/authorStore.ts";

const authorStore = useAuthorStore()

const formControls = reactive({
  form: false,
  loading: false
})
const data = reactive<Author>({
  id: '',
  firstName: '',
  lastName: '',
  country: '',
  birthday: new Date(),
  biography: ''
})


const rules = {
  required: (value: string) => !!value || 'Field is required',
}

const onSubmit = () => {
  formControls.loading = true
  authorStore.registerAuthor(data)
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

<template>
    <div class="col-12 p-0 my-4">
        <h5>Add a comment</h5>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="col-12 p-0">
                    <textarea type="text" class="form-control" placeholder="What do you think about this product ?" rows="5" v-model="$data.form.message"></textarea>
                    <p v-show="has($data.errors,'message')" class="text-danger">{{ $data.errors.message }}</p>              
                </div>  
            </div>
        </div>      
        <div class="col-12 px-0 py-4 text-right">
            <button class="btn btn-primary" @click="save" :disabled="$data.isDisabled">
                <i class="fa fa-spin fa-spinner" v-if="$data.loading"></i>
                Send
            </button>
        </div>        
    </div>
</template>
<script lang="ts" setup>
import { router, usePage } from '@inertiajs/vue3';
import { each, has, isEmpty } from 'lodash';
import { computed, reactive, watch } from 'vue';
import { object, string } from 'yup';

const pageProps:  any = computed( () => usePage().props );

const $data: any = reactive({
    errors: {},
    form:   {
        message: String()
    },
    isDisabled: true,
    loading: false
})

const schema = object().shape({
    message: string().required("Message is required")
})

const save = async () => {
    $data.loading = true
    router.post(
        route('landing.comments.store',{ posting: pageProps.value.posting.id }),
        {
            ...$data.form, 
            _token: pageProps.value.csrf_token            
        },
        {
            onSuccess: ({ props }: any) => {
                $data.form.message = String();
            },
            onFinish: () => {
                $data.loading = false
            }
        }
    );
}

/**
 * Validates a form field based on the provided field name.
 * Uses the formSchema to validate the field and updates the errors object accordingly.
 * Updates the isDisabled property based on the presence of errors.
 *
 * @param {string} field - The name of the field to validate.
 */
const validateForm = async (field:string) => {
    try {
        // Validate the field using the formSchema
        await schema.validateAt(field, $data.form);
		delete $data.errors[field];
    } catch(error: any) {
        // If the field is invalid, update the errors object with the error message
        $data.errors[error.path] = error.message;
    } finally {
        // Update the isDisabled property based on the presence of errors
        $data.isDisabled = !isEmpty($data.errors);
    }
}

/**
 * Watches for changes in the form data.
 *
 * Iterates over each field in the form and validates it using the validateForm function.
 * The watch is set to deep to ensure nested properties are observed.
 */
 watch(
  () => $data.form, 
  (form) => {
    // Iterate over each field in the form and validate it
    each(
      form,
      (value, key) => {
        validateForm(key); // Validate the individual form field
      }
    );
  },
  { 
    deep: true, // Set to true to observe nested properties
    immediate: true
  }
);
</script>
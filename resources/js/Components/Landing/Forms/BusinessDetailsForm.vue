<template>
    <div class="row justify-content-center">
        <div class="col-md-6">

            <form @submit.prevent="submit">
                <div class="form-group">
                  <label for="name" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Name</label>
                  <input type="text" :class="`form-control ${has($data.errors,'name') ? 'border-danger' : '' }`" placeholder="Shop Retailer" id="name" v-model="$data.form.name">
                  <p v-if="has($data.errors,'name')" class="text-danger m-0">{{ $data.errors.name }}</p>              
                </div>
                <div class="form-group">
                  <label for="name" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Email</label>
                  <input type="email" :class="`form-control ${has($data.errors,'email') ? 'border-danger' : '' }`" placeholder="business@example.com" id="email" v-model="$data.form.email">
                  <p v-if="has($data.errors,'email')" class="text-danger m-0">{{ $data.errors.email }}</p>              
                </div>
                <div class="form-group">
                  <label for="name" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Phone Number</label>
                  <VueTelInput @input="getPhoneNumber" :value="$data.form.phone_number" defaultCountry="KE" :styleClasses="`form-control ${has($data.errors,'phone_number') ? 'border-danger' : '' }`" :inputOptions="$data.phoneNumberOptions"/>  
                  <p v-if="has($data.errors,'phone_number')" class="text-danger m-0">{{ $data.errors.phone_number }}</p>              
                </div>
                <div class="form-group">
                  <label for="about" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Description</label>
                  <textarea rows="10" :class="`form-control ${has($data.errors,'about') ? 'border-danger' : '' }`" placeholder="We sell retail items" id="about" v-model="$data.form.about"></textarea>
                  <p v-if="has($data.errors,'about')" class="text-danger m-0">{{ $data.errors.about }}</p>              
                </div>  
                <div class="form-group">
                  <button class="btn btn-primary text-uppercase w-100" type="submit" :disabled="$data.isDisabled">Save Changes</button>
                </div>  
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { each, has, isEmpty, pick } from 'lodash';
import { computed, onMounted, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';
import { object, string } from 'yup';
import { VueTelInput } from 'vue3-tel-input';
import 'vue3-tel-input/dist/vue3-tel-input.css';

const $data: any  = reactive({ 
  errors: Object(),  
  form: {
    about:        String(),
    name:         String(),
    email:        String(),
    phone_number: String(),
  },
  isDisabled:    true,
  phoneNumberOptions: {
    autocomplete: 'off',
    name: 'phone_number',
    placeholder: 'Enter Phone Number',
  },
  schema: {
    about:        string().required("*Description is required"),
    name:         string().required("*Name is required"),
    email:        string().required("*Email Address is required"),
    phone_number: string().required("*Phone Number is required"),
  }
});

const formSchema: any = computed( () => object().shape($data.schema) );

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
        await formSchema.value.validateAt(field, $data.form);
		delete $data.errors[field];
    } catch(error: any) {
        // If the field is invalid, update the errors object with the error message
        $data.errors[error.path] = error.message;
    } finally {
        // Update the isDisabled property based on the presence of errors
        $data.isDisabled = !isEmpty($data.errors);
    }
}

const props = defineProps({
  csrf_token: {
    default: String(),
    type:    String,
    required: true,
  },
  data: {
    default: () => Object(),
    type:    Object,
    required: true,
  },
});

/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
 const submit = () => {
    useForm({ 
      ...$data.form,  
      _token: props.csrf_token 
    }).post(
      route('landing.profile.business'), 
      {
        onSuccess: (value: any) => {
          if( !isEmpty(value.props.flash.message) ){
            toast.success(value.props.flash.message);
          }
        },
      }
    );
};

/**
 * Updates the phone number in the form data.
 *
 * This function extracts the phone number from the event and assigns it to the 
 * phone_number field in the form data. If the event is a String, it uses the 
 * event itself. Otherwise, it accesses the target value of the event.
 *
 * @param {any} $event - The event containing the phone number input.
 */
const getPhoneNumber = ($event: any) => {
  // Check if the event is a string, if so use it directly, otherwise use event target value
  $data.form.phone_number = typeof $event === 'string' ? $event : $event.target.value;
}

onMounted(
  () => {
    $data.form = pick(
      props.data, 
      [
        'about', 
        'name', 
        'email', 
        'phone_number'
      ]
    );
  }
);  

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
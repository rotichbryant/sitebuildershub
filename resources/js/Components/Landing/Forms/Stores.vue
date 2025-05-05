<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="col-12">
                <CreateStore
                    :modal="$data.modals.create"
                    @update:modal="$data.modals.create = $event"
                />
                <button class="btn btn-outline-primary text-uppercase w-100" type="button" @click="$data.modals.create = true">Create Delivery Option</button>
            </div>  
        </div>
    </div>
</template>

<script lang="ts" setup>
import { has, intersection, intersectionBy, keys, map, set } from 'lodash';
import { reactive } from 'vue';
import { VueTelInput } from 'vue3-tel-input';
import 'vue3-tel-input/dist/vue3-tel-input.css';
import { CreateStore } from '../Modals';

const $data  = reactive({ 
  errors: Object(),  
  form: {
    about:        String(),
    name:         String(),
    email:        String(),
    phone_number: String(),
    website:      String(),
  },
  modals: {
    create: Boolean(),
  },    
});

const props = defineProps({
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
//   form.post(
//     route('landing.signup'), 
//     {
//       onSuccess: (value: any) => {
//         if( !isEmpty(value.props.flash.message) ){
//           toast.success(value.props.flash.message);
//           modals.value.signup = false;
//         }
//         resetForm();
//       },
//     }
//   );
};
</script>
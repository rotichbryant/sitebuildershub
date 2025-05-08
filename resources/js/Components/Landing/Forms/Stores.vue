<template>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
              <template v-for="(store,index) in $props.data" :key="store.id">
                <div class="col-md-6">
                    <div class="card">
                      <div class="card-body">
                        <div class="col-12">
                          <h6><span class="fa fa-home mr-2"></span>{{ store.name }}</h6>
                          <h6><span class="fas fa-map-pin mr-2"></span>{{ store.location }}</h6>
                          <h6><span class="fas fa-clock mr-2"></span>{{ store.open_from.time }} - {{ store.open_to.time }}</h6>
                          <h6><span class="fa fa-calendar mr-2"></span>{{ store.timeline.first }} - {{ store.timeline.last }}</h6>
                        </div>
                      </div>
                    </div>
                </div>
              </template>
            </div>
            <div class="col-md-6 my-5 mx-auto">
                <CreateStore
                    :modal="$data.modals.create"
                    @update:modal="$data.modals.create = $event"
                />
                <button class="btn btn-outline-primary text-uppercase w-100" type="button" @click="$data.modals.create = true">Create Store</button>
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

const $props = defineProps({
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
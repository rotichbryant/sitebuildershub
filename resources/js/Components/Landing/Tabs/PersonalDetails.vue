<template>
    <div class="col-12">
        <h5>Personal Details</h5>
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="first_name" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">First Name</label>
                                <input type="text" :class="`form-control ${has($data.errors,'first_name') ? 'border-danger' : '' }`" placeholder="Jane" id="first_name" v-model="$data.form.first_name">
                                <p v-if="has($data.errors,'first_name')" class="text-danger m-0">{{ $data.errors.first_name }}</p>              
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Last Name</label>
                                <input type="text" :class="`form-control ${has($data.errors,'last_name') ? 'border-danger' : '' }`" placeholder="Doe" id="last_name" v-model="$data.form.last_name">
                                <p v-if="has($data.errors,'last_name')" class="text-danger m-0">{{ $data.errors.last_name }}</p>                
                            </div>
                            <div class="form-group">
                                <label for="email" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">E-mail</label>
                                <input type="email" :class="`form-control ${has($data.errors,'email') ? 'border-danger' : '' }`" readonly placeholder="example@gmail.com" id="email" v-model="$data.form.email">
                                <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.email }}</p>                
                            </div>   
                            <div class="form-group">
                                <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Location</label>
                                <Multiselect 
                                    :group-select="true"
                                    group-values="cities" 
                                    group-label="name"
                                    :options="locations"
                                    :multiple="true"
                                    track-by="name" 
                                    label="name"
                                    v-model="$data.form.town"
                                />
                                <p v-show="has($data.errors,'location')" class="text-danger">{{ $data.errors.location }}</p>              
                            </div>  
                            <div class="form-group">
                                <label class="mb-1">Phone Number</label>
                                <VueTelInput v-model="$data.form.phone_number" />  
                            </div> 
                            <div class="form-group">
                                <button class="btn btn-primary text-uppercase w-100" type="submit">Save Changes</button>
                            </div>           
                        </form>                                              
                    </div>
                </div>
            </div>
        </div> 
    </div>   
</template>

<script lang="ts" setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { has, intersection, intersectionBy, keys, map, set } from 'lodash';
import { computed, onMounted, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Multiselect from 'vue-multiselect';
import { VueTelInput } from 'vue3-tel-input';
import 'vue3-tel-input/dist/vue3-tel-input.css';

const pageProps: any = computed( () => usePage().props );

const $data  = reactive({ 
  errors: Object(),  
  form: {
    first_name:   String(),
    last_name:    String(),
    email:        String(),
    town:         String(),
    phone_number: String(),
  }
});

const locations: any = computed( 
    () => map(pageProps.value.locations,
        (cities: any,key: string) => ({ 
            name: key, 
            cities: cities.map( 
                (city: string) => ({ name: city }) 
            ) 
        })
    )
);

/**
 * The login form data.
 *
 * @prop {String} email - The user's email address.
 * @prop {String} password - The user's password.
 * @prop {Boolean} remember - Whether to remember the user.
 */
const form = useForm({
  _token:                pageProps.value.csrf_token,
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

onMounted(
    () => {
        intersection(
            keys($data.form),
            keys(pageProps.value.user),
        ).map(
            (value) => {
                set($data.form,value, pageProps.value.user[value]);
            }
        )
    }
)

watch(
  () => pageProps.errors,
  (value:any) => {
    $data.errors = value;
  },
  { deep: true },
)

</script>
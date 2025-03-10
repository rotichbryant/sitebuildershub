<template>
  <!-- Sign Up Modal -->
  <div class="modal fade form-modal" id="signup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog max-width-px-840 position-relative">
      <button 
        type="button" 
        class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
        @click="modals.signup = false"
      >
        <i class="fas fa-times"></i>
      </button>
      <div class="login-modal-main bg-white rounded-8 overflow-hidden">
        <div class="row no-gutters">
          <div class="col-lg-5 col-md-6">
            <div class="pt-10 pb-6 pl-11 pr-12 bg-black-2 h-100 d-flex flex-column dark-mode-texts">
              <div class="pb-9">
                <h5 class="font-size-8 text-white line-height-reset pb-4 line-height-1p4">
                  Join the Site Builders Hub Community Today!
                </h5>
                <p class="mb-0 font-size-4 text-white">
                  Are you tired of missing out on amazing deals and opportunities? 
                  Do you want to buy and sell with ease and convenience? 
                  Look no further than Site Builders Hub!
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-6">
            <div class="bg-white-2 h-100 px-11 pt-11 pb-7">
              <!-- <div class="row">
                <div class="col-4 col-xs-12">
                  <a href="" class="font-size-4 font-weight-semibold position-relative text-white bg-allports h-px-48 flex-all-center w-100 px-6 rounded-5 mb-4"><i class="fab fa-linkedin pos-xs-abs-cl font-size-7 ml-xs-4"></i> <span class="d-none d-xs-block">Import from LinkedIn</span></a>
                </div>
                <div class="col-4 col-xs-12">
                  <a href="" class="font-size-4 font-weight-semibold position-relative text-white bg-poppy h-px-48 flex-all-center w-100 px-6 rounded-5 mb-4"><i class="fab fa-google pos-xs-abs-cl font-size-7 ml-xs-4"></i> <span class="d-none d-xs-block">Import from Google</span></a>
                </div>
                <div class="col-4 col-xs-12">
                  <a href="" class="font-size-4 font-weight-semibold position-relative text-white bg-marino h-px-48 flex-all-center w-100 px-6 rounded-5 mb-4"><i class="fab fa-facebook-square pos-xs-abs-cl font-size-7 ml-xs-4"></i> <span class="d-none d-xs-block">Import from Facebook</span></a>
                </div>
              </div>
              <div class="or-devider">
                <span class="font-size-3 line-height-reset">Or</span>
              </div> -->
              <form @submit.prevent="submit">
                <div class="form-group">
                  <label for="first_name" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">First Name</label>
                  <input type="text" :class="`form-control ${has($data.errors,'first_name') ? 'border-danger' : '' }`" placeholder="Jane" id="first_name" v-model="form.first_name">
                  <p v-if="has($data.errors,'first_name')" class="text-danger m-0">{{ $data.errors.first_name }}</p>              
                </div>
                <div class="form-group">
                  <label for="last_name" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Last Name</label>
                  <input type="text" :class="`form-control ${has($data.errors,'last_name') ? 'border-danger' : '' }`" placeholder="Doe" id="last_name" v-model="form.last_name">
                  <p v-if="has($data.errors,'last_name')" class="text-danger m-0">{{ $data.errors.last_name }}</p>                
                </div>
                <div class="form-group">
                  <label for="email" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">E-mail</label>
                  <input type="email" :class="`form-control ${has($data.errors,'email') ? 'border-danger' : '' }`" placeholder="example@gmail.com" id="email" v-model="form.email">
                  <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.email }}</p>                
                </div>
                <div class="form-group">
                  <label for="signup-password" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Password</label>
                  <div class="position-relative">
                    <input type="password" :class="`form-control ${has($data.errors,'password') ? 'border-danger' : '' }`" id="signup-password" placeholder="Enter password" v-model="form.password">
                    <a href="#" class="show-password pos-abs-cr fas mr-6 text-black-2" data-show-pass="password2"></a>
                  </div>
                  <p v-if="has($data.errors,'password')" class="text-danger">{{ $data.errors.password }}</p>                
                </div>
                <div class="form-group">
                  <label for="confirmation_password" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Confirm Password</label>
                  <div class="position-relative">
                    <input type="password" :class="`form-control ${has($data.errors,'password_confirmation') ? 'border-danger' : '' }`" id="confirmation_password" placeholder="Enter password" v-model="form.password_confirmation">
                    <a href="#" class="show-password pos-abs-cr fas mr-6 text-black-2" data-show-pass="password23"></a>
                  </div>
                  <p v-if="has($data.errors,'password_confirmation')" class="text-danger">{{ $data.errors.password_confirmation }}</p>              
                </div>
                <div class="form-group d-flex flex-wrap justify-content-between mb-1">
                  <label for="terms-check2" class="gr-check-input d-flex  mr-3">
                    <input class="d-none" type="checkbox" id="terms-check2">
                    <span class="checkbox mr-5"></span>
                    <span class="font-size-3 mb-0 line-height-reset d-block">Agree to the <a href="" class="text-primary">Terms & Conditions</a></span>
                  </label>
                </div>
                <div class="form-group mb-8">
                  <button class="btn btn-primary btn-medium w-100 rounded-5 text-uppercase" type="submit" :disabled="form.processing">
                    <i class="fa fa-spin fa-spinner fa-sm mr-2" v-if="form.processing"></i>
                    Sign Up 
                  </button>
                </div>
                <p class="font-size-4 text-center heading-default-color">
                  Already have an account ? 
                  <a href="javascript:" class="text-primary" @click="modals.login = true">Login</a>
                </p>              
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
</template>
  
<script lang="ts" setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, defineEmits, defineProps, reactive, watch } from 'vue';
import { isEmpty, has, get } from 'lodash'
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const $emit  = defineEmits(['update:modals']);
const $data  = reactive({
  errors: Object(),  
});
const $props = defineProps({
  modals: {
    default: Object(),
    type:    Object,
  } 
});
const jQuery: any  = computed( () => get(window,'jQuery') );
const modals: any  = computed({
    get: ()      => $props.modals,
    set: (value) => $emit('update:modals', value),
});
const pageProps: any = computed( () => usePage().props );

// const $data: any = 
/**
 * The login form data.
 *
 * @prop {String} email - The user's email address.
 * @prop {String} password - The user's password.
 * @prop {Boolean} remember - Whether to remember the user.
 */
const form = useForm({
  _token:                pageProps.value.csrf_token,
  first_name:            String(),
  last_name:             String(),
  email:                 String(),
  password:              String(),
  password_confirmation: String(),
});


const resetForm = () => {
  $data.errors = {};
  form.reset();
}

/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
const submit = () => {
  form.post(
    route('landing.signup'), 
    {
      onSuccess: (value: any) => {
        if( !isEmpty(value.props.flash.message) ){
          toast.success(value.props.flash.message);
          modals.value.signup = false;
        }
        resetForm();
      },
    }
  );
};

watch(
  () => usePage().props.errors,
  (value) => {
    $data.errors = value;
  },
  { deep: true },
)

watch(
  () => $props.modals!.signup,
  (show: boolean) => {
    jQuery.value('#signup').modal( show ? { backdrop: 'static', keyboard: false, show, focus: true } : 'hide');
    if( !show ) resetForm();
  },
)
</script>
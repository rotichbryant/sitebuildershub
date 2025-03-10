<template>
  <div class="modal fade form-modal" id="login" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog max-width-px-840 position-relative">
      <button 
        type="button" 
        class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
        @click="modals.login = false"
      >
        <i class="fas fa-times"></i>
      </button>
      <div class="login-modal-main bg-white rounded-8 overflow-hidden">
        <div class="row no-gutters">
          <div class="col-lg-5 col-md-6">
            <div class="pt-10 pb-6 pl-11 pr-12 bg-black-2 h-100 d-flex flex-column dark-mode-texts">
              <div class="pb-9">
                <h3 class="font-size-8 text-white line-height-reset pb-4 line-height-1p4">
                  Welcome Back
                </h3>
                <p class="mb-0 font-size-4 text-white">Log in to continue your account
                  and explore new jobs.</p>
              </div>
              <!-- <div class="border-top border-default-color-2 mt-auto">
                <div class="d-flex mx-n9 pt-6 flex-xs-row flex-column">
                  <div class="pt-5 px-9">
                    <h3 class="font-size-7 text-white">
                      295
                    </h3>
                    <p class="font-size-3 text-white gr-opacity-5 line-height-1p4">New jobs
                      posted today</p>
                  </div>
                  <div class="pt-5 px-9">
                    <h3 class="font-size-7 text-white">
                      14
                    </h3>
                    <p class="font-size-3 text-white gr-opacity-5 line-height-1p4">New companies
                      registered</p>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
          <div class="col-lg-7 col-md-6">
            <div class="bg-white-2 h-100 px-11 pt-11 pb-7">
              <!-- <div class="row">
                <div class="col-4 col-xs-12">
                  <a href="" class="font-size-4 font-weight-semibold position-relative text-white bg-allports h-px-48 flex-all-center w-100 px-6 rounded-5 mb-4"><i class="fab fa-linkedin pos-xs-abs-cl font-size-7 ml-xs-4"></i> <span class="d-none d-xs-block">Log in with LinkedIn</span></a>
                </div>
                <div class="col-4 col-xs-12">
                  <a href="" class="font-size-4 font-weight-semibold position-relative text-white bg-poppy h-px-48 flex-all-center w-100 px-6 rounded-5 mb-4"><i class="fab fa-google pos-xs-abs-cl font-size-7 ml-xs-4"></i> <span class="d-none d-xs-block">Log in with Google</span></a>
                </div>
                <div class="col-4 col-xs-12">
                  <a href="" class="font-size-4 font-weight-semibold position-relative text-white bg-marino h-px-48 flex-all-center w-100 px-6 rounded-5 mb-4"><i class="fab fa-facebook-square pos-xs-abs-cl font-size-7 ml-xs-4"></i> <span class="d-none d-xs-block">Log in with Facebook</span></a>
                </div>
              </div>
              <div class="or-devider">
                <span class="font-size-3 line-height-reset ">Or</span>
              </div> -->
              <form @submit.prevent="submit">
                <div class="form-group">
                  <label for="login-email" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">E-mail</label>
                  <input type="email" :class="`form-control ${has($data.errors,'email') ? 'border-danger' : '' }`" placeholder="example@gmail.com" id="login-email" v-model="form.email" :invalid="has($data.errors,'email')" autocomplete="off">
                  <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.email }}</p>              
                </div>
                <div class="form-group">
                  <label for="password" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Password</label>
                  <div class="position-relative">
                    <input type="password" :class="`form-control ${has($data.errors,'password') ? 'border-danger' : '' }`" id="login-password" placeholder="Enter password" v-model="form.password" :invalid="has($data.errors,'password')" autocomplete="off">
                    <p v-if="has($data.errors,'password')" class="text-danger">{{ $data.errors.password }}</p>                  
                    <a href="#" class="show-password pos-abs-cr fas mr-6 text-black-2" data-show-pass="password"></a>
                  </div>
                </div>
                <div class="form-group d-flex flex-wrap justify-content-between">
                  <label for="terms-check" class="gr-check-input d-flex  mr-3">
                    <input class="d-none" type="checkbox" id="terms-check">
                    <span class="checkbox mr-5"></span>
                    <span class="font-size-3 mb-0 line-height-reset mb-1 d-block">Remember password</span>
                  </label>
                  <a href="" class="font-size-3 text-dodger line-height-reset">Forgot Password</a>
                </div>
                <div class="form-group mb-8">
                  <button class="btn btn-primary btn-medium w-100 rounded-5 text-uppercase" :disabled="form.processing">
                    <i class="fa fa-spin fa-spinner mr-2" v-if="form.processing"></i>
                    Log in 
                  </button>
                </div>
                <p class="font-size-4 text-center heading-default-color">
                  Don’t have an account? 
                  <a href="javascript:" class="text-primary" @click.prevent="modals.signup = true">Create a free account</a>
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
import { cloneDeep, has, get } from 'lodash'

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
  _token:   pageProps.csrf_token,
  email:    String(),
  password: String(),
  remember: Boolean(),
});

/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
 const submit = () => {
    form.post(
      route('landing.login'), 
      {
        onSuccess: (value) => {
          resetForm();
        },
        onError: (value) => {
            console.log(value)
        },
      }
  );
};

/**
 * Resets the form data.
 *
 * Resets the email and password fields and clears the error state.
 */
const resetForm = () => {
  // Reset the form fields
  form.reset('email');
  form.reset('password');

  // Clear the error state
  $data.errors = cloneDeep({});
}

watch(
  () => usePage().props.errors,
  (value) => {
    $data.errors = cloneDeep(value);
  },
  { deep: true },
)

watch(
  () => $props.modals!.login,
  (show: boolean) => {
    jQuery.value('#login').modal( show ? { backdrop: 'static', keyboard: false, show, focus: true } : 'hide');
    if( !show ) resetForm();
  },
)
</script>
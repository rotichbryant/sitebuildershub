<template>
  <CModal 
    alignment="center"
    scrollable
    backdrop
    size="lg"
    :visible="modal"
    @close="modal = false"
    aria-labelledby="VerticallyCenteredExample2"
  >
  <CModalBody class="p-0">
      <CCardGroup>
        <CCard color="primary">
          <CCardBody class="d-flex align-items-center justify-content-center text-white">
            <CContainer class="p-4">
              <h3>Welcome Back to Site Builders Hub!</h3>
              <p>
                Login to your Site Builders Hub account to access your favorite features and start selling today!
              </p>
            </CContainer>
          </CCardBody>
        </CCard>
        <CCard>
          <CCardBody class="p-4">
            <CForm @submit.prevent="submit">
              <CCol :md="12">
                <h5> Please provide valid credentials </h5>
              </CCol>
              <CCol :md="12" class="mb-3">
                <CInputGroup >
                    <CInputGroupText>
                        <CIcon icon="cil-envelope-closed" />
                    </CInputGroupText>
                    <CFormInput
                      placeholder="Email Address"
                      v-model="form.email"
                      :invalid="has($data.errors,'email')"
                    />
                </CInputGroup>
                <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.email }}</p>
              </CCol>
              <CCol :md="12" class="mb-3">
                <CInputGroup>
                    <CInputGroupText>
                      <CIcon icon="cil-lock-locked" />
                    </CInputGroupText>
                    <CFormInput
                      type="password"
                      placeholder="Password"
                      v-model="form.password"
                      :invalid="has($data.errors,'password')"
                    />
                </CInputGroup>
                <p v-if="has($data.errors,'password')" class="text-danger">{{ $data.errors.password }}</p>
              </CCol>              
              <CCol :md="12" class="d-flex justify-content-between">
                <CButton color="primary" type="submit"><CSpinner v-if="form.processing"/>Login</CButton>
                <CButton color="secondary" @click="modal = false">Close</CButton>
              </CCol>
            </CForm>
          </CCardBody>
        </CCard>
      </CCardGroup>
    </CModalBody>
  </CModal>    
</template>

<script lang="ts" setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, defineEmits, defineProps, reactive, watch } from 'vue';
import { has } from 'lodash'

const $emit  = defineEmits(['update:modal']);
const $data  = reactive({
  errors: Object(),  
});
const $props = defineProps({
   show: {
    default: Boolean(),
    type:    Boolean,
   } 
});

const modal  = computed({
    get: ()      => $props.show,
    set: (value) => $emit('update:modal', value),
});


// const $data: any = 
/**
 * The login form data.
 *
 * @prop {String} email - The user's email address.
 * @prop {String} password - The user's password.
 * @prop {Boolean} remember - Whether to remember the user.
 */
 const form = useForm({
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
            form.reset('email');
            form.reset('password');
          },
        onError: (value) => {
            console.log(value)
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
</script>
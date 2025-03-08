<template>
  <CModal 
    alignment="center"
    scrollable
    backdrop
    :visible="modal"
    @close="modal = false"
    size="xl"
    aria-labelledby="VerticallyCenteredExample2"
  >
    <CModalBody class="p-0">
      <CCardGroup>
        <CCard color="primary">
          <CCardBody class="d-flex align-items-center justify-content-center text-white">
            <CContainer>
              <h3>Join the Site Builders Hub Community Today!</h3>
              <p>
                Are you tired of missing out on amazing deals and opportunities? 
                Do you want to buy and sell with ease and convenience? 
                Look no further than Site Builders Hub!
              </p>
            </CContainer>
          </CCardBody>
        </CCard>
        <CCard>
          <CCardBody class="p-4">
            <CForm @submit.prevent="submit">
              <!-- <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                  {{ status }}
              </div> -->
              <CCol :md="12">
                <h5> Fill in the form below to get started </h5>
              </CCol>
              <CRow class="mb-3">
                <CCol :md="6">
                  <CInputGroup>
                    <CInputGroupText>
                        <CIcon icon="cil-user" />
                    </CInputGroupText>
                    <CFormInput
                      placeholder="First Name"
                      v-model="form.first_name"
                      :invalid="has($data.errors,'first_name')"
                    />
                  </CInputGroup>
                  <p v-if="has($data.errors,'first_name')" class="text-danger m-0">{{ $data.errors.first_name }}</p>
                </CCol>
                <CCol :md="6">
                  <CInputGroup>
                    <CInputGroupText>
                        <CIcon icon="cil-user" />
                    </CInputGroupText>
                    <CFormInput
                      placeholder="Last Name"
                      v-model="form.last_name"
                      :invalid="has($data.errors,'last_name')"
                    />
                  </CInputGroup>
                  <p v-if="has($data.errors,'last_name')" class="text-danger m-0">{{ $data.errors.last_name }}</p>
                </CCol>
              </CRow>
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
              <CCol :md="12" class="mb-3">
                <CInputGroup>
                    <CInputGroupText>
                      <CIcon icon="cil-lock-locked" />
                    </CInputGroupText>
                    <CFormInput
                      type="password"
                      placeholder="Confirm Password"
                      v-model="form.password_confirmation"
                      :invalid="has($data.errors,'password_confirmation')"
                    />
                </CInputGroup>
                <p v-if="has($data.errors,'password_confirmation')" class="text-danger">{{ $data.errors.password_confirmation }}</p>
              </CCol>
              <CCol :md="12" class="d-flex justify-content-between">
                <CButton color="primary" type="submit"><CSpinner v-if="form.processing"/>Signup</CButton>
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
    set: (value) => {
      if( !value ) $data.errors = {};
      $emit('update:modal', value)
    },
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
      first_name:            String(),
      last_name:             String(),
      email:                 String(),
      password:              String(),
      password_confirmation: String(),
  });
  
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
          onSuccess: (value) => {
            form.reset('first_name');
            form.reset('last_name');
            form.reset('email');
            form.reset('password');
            form.reset('password_confirmation');
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
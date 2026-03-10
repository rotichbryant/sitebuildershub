<template>
    <AuthenticatedLayout>
        <Head title="Profile | Dashboard" />
        <CRow>
            <CCol md="12">
                <h3>Profile</h3>
                <p>User profile and details</p>
            </CCol>
            <CCol md="12"> 
                <CRow>
                    <CCol md="6" xs="12">
                        <CCard class="mb-4" id="logo-icon">
                            <CCardBody>
                                <CCol md="12">
                                    <CRow>
                                        <CCol md="12">
                                            <label>Avatar</label>
                                            <vue-dropzone
                                                ref="system-logo" 
                                                id="system-logo" 
                                                :options="$data.dropzoneOptions"
                                            /> 
                                        </CCol>
                                        <CCol md="12">
                                            <CFormInput
                                                type="text"
                                                label="First Name"
                                                v-model="$data.form.first_name"
                                                class="mb-2"
                                            />  
                                        </CCol>
                                        <CCol md="12">
                                            <CFormInput
                                                type="text"
                                                label="Last Name"
                                                v-model="$data.form.last_name"
                                                class="mb-2"
                                            />  
                                        </CCol>
                                        <CCol md="12">
                                            <CFormInput
                                                type="email"
                                                label="Email Address"
                                                v-model="$data.form.email"
                                                class="mb-2"
                                            />  
                                        </CCol>
                                        <CCol md="12" class="my-2">
                                            <label class="mb-1">Phone Number</label>
                                            <VueTelInput
                                                v-model="$data.form.phone_number"
                                            />  
                                        </CCol>
                                        <CCol md="12">
                                            <CButton color="primary" @click="saveChanges">Save Changes</CButton>
                                        </CCol>
                                    </CRow>       
                                </CCol>   
                            </CCardBody>
                        </CCard>    
                    </CCol>
                </CRow>
            </CCol>
        </CRow>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, reactive, watch } from 'vue';
import vueDropzone from 'dropzone-vue3'
import { pick } from 'lodash';
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

const $data: any = reactive({
    tab: 1,
    dropzoneOptions: {
        url: 'https://httpbin.org/post',
        thumbnailWidth: 150,
        maxFilesize: 0.5,
        headers: { "My-Awesome-Header": "header value" }
    },
    form:   {},
    errors: {}
});

const pageProps: any = computed( () => usePage().props );

const saveChanges = () => {

}

const resetForm = () => {
  // Reset the form fields
//   form.reset('email');
//   form.reset('password');

  // Clear the error state
  $data.errors = cloneDeep({});
}


/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
 const submit = () => {
    $data.form.post(
      route('landing.login'), 
      {

        onSuccess: (value: any) => {
          if( !isEmpty(value.props.flash.message) ){
            toast.success(value.props.flash.message);
          }
          resetForm();
          // modals.value.login = false;
        },
      }
    );
};

watch(
    () => pageProps.value.auth.user,
    (user) => {
        $data.form = useForm({ ...pick(user,['first_name','last_name','email','phone_number','picture']), _token: pageProps.value.csrf_token })
    },
    { immediate: true }
)
</script>
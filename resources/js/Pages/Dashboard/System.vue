<template>
    <AuthenticatedLayout>
        <Head title="System | Dashboard" />
        <CRow>
            <CCol :md="12">
                <h3>System</h3>
                <p>Mail Settings, Payment Gateway, App Logo and Icon.</p>
            </CCol>
            <CCol :md="12"> 
                <CRow>
                    <CCol :md="10">
                        <CCard class="mb-4" id="logo-icon">
                            <CCardHeader>
                                <strong>App Logo & Icon</strong>
                            </CCardHeader>
                            <CCardBody>
                                <CCol :md="12" class="mb-4">
                                    <CCol :md="6">
                                        <CRow>
                                            <CCol :md="12" class="mb-2">
                                                <h6>Icon</h6>
                                                <vue-dropzone
                                                    ref="system-icon" 
                                                    id="system-icon" 
                                                    :options="$data.dropzoneOptions"
                                                /> 
                                            </CCol>
                                            <CCol :md="12">
                                                <h6>Logo</h6>
                                                <vue-dropzone
                                                    ref="system-logo" 
                                                    id="system-logo" 
                                                    :options="$data.dropzoneOptions"
                                                /> 
                                            </CCol>
                                        </CRow> 
                                    </CCol>          
                                </CCol> 
                            </CCardBody>
                        </CCard>
                        <CCard class="mb-4" id="mail">
                            <CCardHeader>
                                <strong>Mail Settings</strong>
                            </CCardHeader>
                            <CCardBody>
                                <CCol :md="12" class="mb-4">
                                    <CCol :md="4 ">
                                        <CFormInput
                                            type="email"
                                            label="Mail Host"
                                            class="mb-2"
                                        />  
                                        <CFormInput
                                            type="email"
                                            label="Mail Username"
                                            class="mb-2"
                                        />  
                                        <CFormInput
                                            type="email"
                                            label="Mail Password"
                                            class="mb-2"
                                        />  
                                        <CFormInput
                                            type="number"
                                            label="Mail Port"
                                        />       
                                    </CCol>          
                                </CCol>  
                            </CCardBody>
                        </CCard>      
                        <CCard class="mb-4" id="payment">
                            <CCardHeader>
                                <strong>Payment Gateway</strong>
                            </CCardHeader>
                            <CCardBody>
                                <CCol :md="12">
                                    <CCol :md="4 ">
                                        <CFormInput
                                            type="email"
                                            label="Mail Host"
                                            class="mb-2"
                                        />  
                                        <CFormInput
                                            type="email"
                                            label="Mail Username"
                                            class="mb-2"
                                        />  
                                        <CFormInput
                                            type="email"
                                            label="Mail Password"
                                            class="mb-2"
                                        />  
                                        <CFormInput
                                            type="number"
                                            label="Mail Port"
                                        />       
                                    </CCol>          
                                </CCol>  
                            </CCardBody>
                        </CCard>
                    </CCol>
                    <CCol :md="2">
                        <CNav class="flex-column position-fixed" variant="underline">
                            <CNavItem>
                                <CNavLink href="#logo-icon" class="py-0"> App Logo & Icon </CNavLink>
                            </CNavItem>
                            <CNavItem>
                                <CNavLink href="#mail" class="py-0"> Mail Settings </CNavLink>
                            </CNavItem>
                            <CNavItem>
                                <CNavLink href="#payment" class="py-0"> Payment Gateway </CNavLink>
                            </CNavItem>
                        </CNav>
                    </CCol>
                </CRow>
            </CCol>
        </CRow>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import vueDropzone from 'dropzone-vue3'

const $data: any = reactive({
    tab: 1,
    dropzoneOptions: {
        url: 'https://httpbin.org/post',
        thumbnailWidth: 150,
        maxFilesize: 0.5,
        headers: { "My-Awesome-Header": "header value" }
    }
})
</script>
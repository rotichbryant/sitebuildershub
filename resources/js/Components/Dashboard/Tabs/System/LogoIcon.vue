<template>
    <CCard class="mb-4" id="logo-icon">
        <CCardBody>
            <CCol md="12">
                <CCol md="6">
                    <CRow>
                        <CCol md="12" class="mb-2">
                            <h6>Icon</h6>
                            <vue-dropzone
                                ref="system-icon" 
                                id="system-icon" 
                                :options="$data.icon_options"
                                @vdropzone-sending="addExtraFormData"
                                @vdropzone-success="successFileUpload"
                            /> 
                        </CCol>
                        <CCol md="12">
                            <h6>Logo</h6>
                            <vue-dropzone
                                ref="system-logo" 
                                id="system-logo" 
                                :options="$data.logo_options"
                                @vdropzone-sending="addExtraFormData"
                                @vdropzone-success="successFileUpload"
                            /> 
                        </CCol>
                    </CRow> 
                </CCol>
            </CCol> 
        </CCardBody>
    </CCard>    
</template>

<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import vueDropzone from 'dropzone-vue3'
import { useForm, usePage } from '@inertiajs/vue3';
import { pick } from 'lodash';

const $data: any = reactive({
    tab: 1,
    icon_options: {
        paramName:      'icon',
        url:            route('dashboard.system'),
        method:         'post',
        thumbnailWidth: 150,
        maxFilesize:    1.0,
    },
    logo_options: {
        paramName:      'logo',
        url:            route('dashboard.system'),
        method:         'post',
        thumbnailWidth: 150,
        maxFilesize:    2.6,
    },
    form:   {},
    errors: {}
})


const pageProps: any = computed( () => usePage().props );


const saveChanges = () => {

}

const addExtraFormData = (file: any,xhr: any, formData: any) => {
    formData.append('tab',   'images');
    formData.append('_token', pageProps.value.csrf_token);
}

const successFileUpload = (file, response) => {
    console.log(response);
}

watch(
    () => pageProps.value.images,
    (images) => {
        $data.form = useForm({ 
            ...pick(images,['logo','icon']), 
            _token: pageProps.value.csrf_token 
        })
    },
    { immediate: true }
);
</script>
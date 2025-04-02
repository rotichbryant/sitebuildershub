<template>
    <div class="modal fade" tabindex="-1"  id="create-advert">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Advert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="modals.create = false"></button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Upload Images</label>
                                <vue-dropzone
                                    ref="images" 
                                    id="images" 
                                    :options="$data.logo_options"
                                    @vdropzone-sending="addExtraFormData"
                                    @vdropzone-success="successFileUpload"
                                /> 
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Title</label>
                                <input type="text" :class="`form-control ${has($data.errors,'title') ? 'border-danger' : '' }`" placeholder="eg Drill" id="login-email" v-model="form.title" :invalid="has($data.errors,'title')" autocomplete="off">
                                <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.title }}</p>              
                            </div>
                            <div class="form-group col-12">
                                <!-- <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Category</label> -->
                                <select name="category" v-model="form.category" class="form-control">
                                    <options value="">Select Category*</options>
                                    <option value="" v-for="category in $data.categories" :key="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>                                
                                <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.title }}</p>              
                            </div>
                            <!-- <div class="form-group col-12">
                                <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Sub Category</label>
                                <select name="category" v-model="form.category" class="form-control">
                                    <options value="">Select Sub Category*</options>
                                    <option value="" v-for="category in categories" :key="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                                <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.title }}</p>              
                            </div> -->
                            <div class="form-group">
                                <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Title</label>
                                <input type="text" :class="`form-control ${has($data.errors,'title') ? 'border-danger' : '' }`" placeholder="eg Drill" id="login-email" v-model="form.title" :invalid="has($data.errors,'title')" autocomplete="off">
                                <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.title }}</p>              
                            </div>
                            <div class="form-group">
                                <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Title</label>
                                <input type="text" :class="`form-control ${has($data.errors,'title') ? 'border-danger' : '' }`" placeholder="eg Drill" id="login-email" v-model="form.title" :invalid="has($data.errors,'title')" autocomplete="off">
                                <p v-if="has($data.errors,'email')" class="text-danger">{{ $data.errors.title }}</p>              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>    
</template>
  
<script lang="ts" setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, defineEmits, defineProps, reactive, watch } from 'vue';
import { cloneDeep, isEmpty, has, get } from 'lodash';
import vueDropzone from 'dropzone-vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const $emit  = defineEmits(['update:modals']);

const $data  = reactive({
    logo_options: {
        paramName:      'images',
        url:            route('landing.mypostings.create'),
        method:         'post',
        thumbnailWidth: 150,
        maxFilesize:    2.6,
    },
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
    set: (value:any) => $emit('update:modals', value),
});

const pageProps: any = computed( () => usePage().props );

const addExtraFormData = (file: any,xhr: any, formData: any) => {
    formData.append('tab',   'images');
    formData.append('_token', pageProps.value.csrf_token);
}

// const $data: any = 
/**
 * The login form data.
 * 
 * @prop {String} email - The user's email address.
 * @prop {String} password - The user's password.
 * @prop {Boolean} remember - Whether to remember the user.
 */
const form = useForm({
_token:       pageProps.value.csrf_token,
title:        String(),
category:     String(),
sub_category: String(),
quantity:     Number(),
images:       Array(),
description:  String(),
negotiate:    String(),
phone_number: String()
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

const successFileUpload = (file, response) => {
    console.log(response);
}

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
    (value:any) => {
        $data.errors = cloneDeep(value);
    },
    { deep: true },
)

watch(
    () => $props.modals!.create,
    (show: boolean) => {
        jQuery.value('#create-advert').modal( show ? { backdrop: 'static', keyboard: false, show, focus: true } : 'hide');
        if( !show ) resetForm();
    },
)
</script>
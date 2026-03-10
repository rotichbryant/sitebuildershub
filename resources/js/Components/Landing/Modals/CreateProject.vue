<template>
    <div class="modal fade" tabindex="-1"  id="create-project">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="modals.create = false"></button>
                </div>
                <form @submit.prevent="submit">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Title</label>
                                    <input type="text" id="title" class="form-control" v-model="$data.form.title">
                                    <p v-if="has($data.errors,'title')" class="text-danger">{{ $data.errors.title }}</p>                
                                </div>  
                            </div>                                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Start Date</label>
                                    <input type="date" id="start_date" class="form-control" v-model="$data.form.start_date">
                                    <p v-if="has($data.errors,'start_date')" class="text-danger">{{ $data.errors.start_date }}</p>                
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Start Date</label>
                                    <input type="date" id="start_date" class="form-control" v-model="$data.form.end_date">
                                    <p v-if="has($data.errors,'end_date')" class="text-danger">{{ $data.errors.end_date }}</p>                
                                </div>  
                            </div>     
                            <div class="col-12">
                                <label for="content" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Content</label>
                                <div class="col-12 px-0">
                                    <QuillEditor theme="snow" v-model:content="$data.form.content" content-type="html"/>
                                </div>
                                <p v-if="has($data.errors,'content')" class="text-danger">{{ $data.errors.content }}</p>                
                            </div>   
                            <div class="col-12">
                                <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Add Photo</label>
                                <vue-dropzone
                                    ref="images" 
                                    id="images" 
                                    :options="$data.file_options"
                                    @vdropzone-sending="addExtraFormData"
                                    @vdropzone-success="successFileUpload"
                                />    
                                <p v-show="has($data.errors,'images')" class="text-danger">{{ $data.errors.images }}</p>              
                            </div>                                              
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" @click="closeModal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</template>
  
<script lang="ts" setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, defineEmits, defineProps, reactive, watch } from 'vue';
import { cloneDeep, isEmpty, has, get, each } from 'lodash';
import vueDropzone from 'dropzone-vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { array, object, string } from 'yup';

const $emit  = defineEmits(['update:modal']);

const $data: any  = reactive({
    logo_options: {
        paramName:      'images',
        url:            route('landing.mypostings.create'),
        method:         'post',
        thumbnailWidth: 150,
        maxFilesize:    2.6,
    },
    errors: Object(),
    file_options: {
        paramName:      'file',
        url:            route('landing.profile.project.file'),
        method:         'post',
        acceptedFiles:  'image/*',
        // headers:        {'Content-Type': 'multipart/form-data'}
    },    
    form: {
        content:    "",
        end_date:   "",
        files:      [],
        start_date: "",
        title:      "",
    },
    schema: {
        content:    string().required("*Content is required"),
        end_date:   string().required("*End Date is required"),
        images:     array().min(1,'*Please select at least one file').required("*Please select at least one file"),
        start_date: string().required("*Start Date is required"),
        title:      string().required("*Title is required"),
    }    
});

const formSchema: any = computed( () => object().shape($data.schema) );

const $props = defineProps({
    modal: {
        default: Boolean(),
        type:    Boolean,
    } 
});

const jQuery: any  = computed( () => get(window,'jQuery') );

const pageProps: any = computed( () => usePage().props );


const addExtraFormData = (file: any,xhr: any, formData: any) => {
    formData.append('_token', pageProps.value.csrf_token);
}

/**
 * Called when a file is successfully uploaded.
 * 
 * @param {Object} _ - The file object.
 * @param {Object} { name } - The file name.
 */
const successFileUpload = (_: any, { name }: any) => {
    // Add the file name to the images array
    $data.form.files.push(name);
}
/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
const submit = () => {
    useForm({
        _token: pageProps.value.csrf_token,
        ...$data.form
    }).post(
        route('landing.profile.project.store'), 
        {
            onSuccess: (value: any) => {
                if( !isEmpty(value.props.flash.message) ){
                    toast.success(value.props.flash.message);
                }
                resetForm();
                setTimeout(
                    () => {
                        window.location.reload();
                    }
                )
            // modals.value.login = false;
            },
        }
    );
};

/**
 * Closes the create project modal.
 *
 * Sets the modal value to false and hides the modal using jQuery.
 */
const closeModal = () => {
    // Set the modal value to false
    $emit('update:modal', false)

    $data.form = {
        content:    "",
        end_date:   "",
        start_date: "",
        title:      "",        
    }
    
    // Hide the modal using jQuery
    jQuery.value('#create-project').modal('hide');
}

/**
 * Resets the form data.
 *
 * Resets the email and password fields and clears the error state.
 */
const resetForm = () => {
    $data.form.splice(0)

    // Clear the error state
    $data.errors = cloneDeep({});
}

/**
 * Validates a form field based on the provided field name.
 * Uses the formSchema to validate the field and updates the errors object accordingly.
 * Updates the isDisabled property based on the presence of errors.
 *
 * @param {string} field - The name of the field to validate.
 */
const validateForm = async (field:string) => {
    try {
        // Validate the field using the formSchema
        await formSchema.value.validateAt(field, $data.form);
		delete $data.errors[field];
    } catch(error: any) {
        // If the field is invalid, update the errors object with the error message
        $data.errors[error.path] = error.message;
    } finally {
        // Update the isDisabled property based on the presence of errors
        $data.isDisabled = !isEmpty($data.errors);
    }
}

/**
 * Watches for changes in the form data.
 *
 * Iterates over each field in the form and validates it using the validateForm function.
 * The watch is set to deep to ensure nested properties are observed.
 */
 watch(
  () => $data.form, 
  (form) => {
    // Iterate over each field in the form and validate it
    each(
      form,
      (value, key) => {
        validateForm(key); // Validate the individual form field
      }
    );
  },
  { 
    deep: true, // Set to true to observe nested properties
    immediate: true
  }
);

watch(
    () => usePage().props.errors,
    (value:any) => {
        $data.errors = cloneDeep(value);
    },
    { deep: true },
)

watch(
    () => $props.modal,
    (show: boolean) => {
        
        jQuery.value('#create-project').modal( show ? { backdrop: 'static', keyboard: false, show, focus: true } : 'hide');
        
        if( !show ) resetForm();

    },
)
</script>
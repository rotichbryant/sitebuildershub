<template>
    <div class="col-12">
        <h5>Personal Details</h5>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Add Photo</label>
                                <vue-dropzone
                                    ref="profile_image"
                                    id="image"                             
                                    :options="$data.file_options"
                                    @vdropzone-sending="addExtraFormData"
                                    @vdropzone-success="successFileUpload"
                                />    
                                <p v-show="has($data.errors,'images')" class="text-danger">{{ $data.errors.images }}</p>              
                            </div>                            
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
                                <input type="email" class="form-control" readonly placeholder="example@gmail.com" id="email" :value="pageProps.auth.user.email">             
                            </div>   
                            <!-- <div class="form-group">
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
                            </div>   -->
                            <div class="form-group">
                                <label class="mb-1">Phone Number</label>
                                <VueTelInput 
                                    :value="$data.form.phone_number"
                                    @input="getPhoneNumber" 
                                    defaultCountry="KE" 
                                    :inputOptions="{ styleClasses: 'form-control bg-white', placeholder: 'Phone Number' }" 
                                    mode="international"
                                /> 
                            </div> 
                            <div class="form-group">
                                <button class="btn btn-primary text-uppercase w-100" type="submit" :disabled="$data.isDisabled">Save Changes</button>
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
import { cloneDeep, each, has, intersection, intersectionBy, isEmpty, keys, map, set } from 'lodash';
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Multiselect from 'vue-multiselect';
import { VueTelInput } from 'vue3-tel-input';
import 'vue3-tel-input/dist/vue3-tel-input.css';
import { object, string } from 'yup';
import vueDropzone from 'dropzone-vue3';

const pageProps: any = computed( () => usePage().props );

const profile_image: any = ref(null);

const $data: any  = reactive({
    errors: Object(),
    file_options: {
        paramName:      'file',
        url:            route('landing.profile.personal.image'),
        method:         'post',
        acceptedFiles:  'image/png, image/jpg, image/jpeg',
        thumbnailWidth: 200,
        maxFilesize:    2.6,        
        // headers:        {'Content-Type': 'multipart/form-data'}
    },    
    isDisabled: true,
    form: {
        first_name:   String(),
        last_name:    String(),
        // town:         String(),
        phone_number: String(),
        picture:      String()
    },
    schema: {
        first_name:   string().required("*First Name is required"),
        last_name:    string().required("*Last Name is required"),
        phone_number: string().required("*Phone Number is required"),
        picture:      string().nullable(),
    }    
});

const formSchema: any = computed( () => object().shape($data.schema) );

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
    $data.form.picture = name;
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
        route('landing.profile.personal'),
        {
            onSuccess: (value: any) => {
                if( !isEmpty(value.props.flash.message) ){
                    toast.success(value.props.flash.message);
                }
            },
        }
    );
};

/**
 * Update the phone number in the form data.
 *
 * @param {Event|String} $event - The event object or the phone number.
 * @return {void}
 */
const getPhoneNumber = ($event) => {
    // Check if the event is a string or not.
    // If it's a string, assign it to the phone number field.
    // If it's an event object, assign the value of the target to the phone number field.
    $data.form.phone_number = $event.constructor == String ? $event : $event.target.value.trim()
}

/**
 * Gets the size of an image from a given URL.
 *
 * @param {string} url - The URL of the image.
 * @returns {Promise<number|null>} - The size of the image in bytes, or null if it could not be determined.
 */
const getImageSize = async (url: string): Promise<any|null> => {
    const response = await fetch(url, { method: 'HEAD' });
    
    // Get the Content-Length header, which should contain the size of the image in bytes.
    const size = response.headers.get('Content-Length');

    // Get the Content-Length header, which should contain the size of the image in bytes.
    const type = response.headers.get('Content-Type');
    
    // If the size is defined, return it as an integer. Otherwise, return null.
    return { size: size ? parseInt(size, 10) : null, type };
}

const addExistingImageToProfileImage = async (image: string) => {
    
    const { size, type } = await getImageSize(image);

    profile_image.value.manuallyAddFile({ name: `icon.${type.split('/')[1]}`, size, type },image)

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

onMounted(
    () => {
        if( !isEmpty(pageProps.value.user.pictureUrl) ){
            addExistingImageToProfileImage(pageProps.value.user.pictureUrl)
        }

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
  () => pageProps.errors,
  (value:any) => {
    $data.errors = value;
  },
  { deep: true },
)

</script>
<template>
    <!-- Category Creation Modal -->
    <CModal
        :visible="showModal"
        @close="closeModal"
        alignment="center"
        title="Create Subscription"
        size="lg"
    >
        <CModalHeader>
            <CModalTitle>Edit Subscription </CModalTitle>
        </CModalHeader>
        <form @submit.prevent="submitForm">
            <CModalBody>
                <CRow>
                    <CCol md="5">
                        <CRow>
                            <CCol md="12">                        
                                <CFormInput
                                    id="name"
                                    v-model="$data.form.name"
                                    label="Name"
                                    placeholder="Enter subscription name"
                                    :invalid="has($data.errors,'name') ? true : false"
                                />
                                <p v-show="has($data.errors,'name')" class="text-danger">{{ $data.errors.name }}</p>              
                            </CCol> 
                            <CCol md="12">   
                                <CFormLabel for="price">Price</CFormLabel>
                                <CInputGroup class="has-validation">
                                    <CInputGroupText id="append-price">KSH</CInputGroupText>
                                    <CFormInput
                                        id="price"
                                        v-model.number="$data.form.price"
                                        type="number"
                                        min="0"
                                        placeholder="Cost of subscription"
                                        :invalid="has($data.errors,'price') ? true : false"
                                    />  
                                </CInputGroup>  
                                <p v-show="has($data.errors,'price')" class="text-danger">{{ $data.errors.price }}</p>              
                            </CCol>   
                            <CCol md="12">                        
                                <CFormTextarea
                                    id="description"
                                    label="Description" 
                                    rows="4"
                                    text="Write something about this subscription"
                                    v-model="$data.form.description"
                                ></CFormTextarea>       
                                <p v-show="has($data.errors,'description')" class="text-danger">{{ $data.errors.description }}</p>              
                            </CCol> 
                            <CCol md="12" class="mt-2">
                                <CFormLabel for="active">Status</CFormLabel>
                                <CFormSwitch size="xl" v-model="$data.form.active" :label="$data.form.active ? 'Active' : 'Inactive'" id="active"/>
                                <p v-show="has($data.errors,'active')" class="text-danger">{{ $data.errors.active }}</p>              
                            </CCol>
                            <CCol md="12" class="mt-2">
                                <CFormLabel for="default">Default</CFormLabel>
                                <CFormSwitch size="xl" v-model="$data.form.default" :label="$data.form.default ? 'Yes' : 'No'" id="default"/>
                                <p v-show="has($data.errors,'default')" class="text-danger">{{ $data.errors.default }}</p>              
                            </CCol>                            
                        </CRow>
                    </CCol>
                    <CCol md="7" class="border border-left-0 border-top-0 border-bottom-0">
                        <CRow>
                            <CCol md="12">
                                <CFormInput
                                    id="max_posts"
                                    v-model.number="$data.form.features.max_posts"
                                    label="Max Number Of Posts"
                                    placeholder="Enter max number of posts"
                                    :invalid="has($data.errors,'features.max_posts') ? true : false"
                                    type="number"
                                    min="0"
                                    text="Set 0 to disable this feature"
                                />
                                <p v-show="has($data.errors,'features.max_posts')" class="text-danger">{{ $data.errors['features.max_posts'] }}</p>              
                            </CCol>  
                            <CCol md="12" class="mt-2">
                                <CFormLabel for="active">For Businesses</CFormLabel>
                                <CFormSwitch size="xl" v-model="$data.form.features.for_businesses" :label="$data.form.features.for_businesses ? 'Active' : 'Inactive'" id="active"/>
                                <p v-show="has($data.errors,'features.for_businesses')" class="text-danger">{{ $data.errors['features.for_businesses'] }}</p>              
                            </CCol>
                            <CCol md="12" class="mt-2">
                                <CFormLabel for="active">For Professionals</CFormLabel>
                                <CFormSwitch size="xl" v-model="$data.form.features.for_professionals" :label="$data.form.features.for_professionals ? 'Active' : 'Inactive'" id="for_professionals"/>
                                <p v-show="has($data.errors,'features.for_professionals')" class="text-danger">{{ $data.errors['features.for_professionals'] }}</p>              
                            </CCol> 
                            <CCol md="12" class="mt-2">
                                <CFormLabel for="active">Can Comment ?</CFormLabel>
                                <CFormSwitch size="xl" v-model="$data.form.features.can_comment" :label="$data.form.features.can_comment ? 'Active' : 'Inactive'" id="can_comment"/>
                                <p v-show="has($data.errors,'features.can_comment')" class="text-danger">{{ $data.errors['features.can_comment'] }}</p>              
                            </CCol>                                                                                                                                                                                 
                        </CRow>
                    </CCol>
                </CRow>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="closeModal">
                    Close
                </CButton>
                <CButton color="primary" type="submit" :disabled="$data.isDisabled">
                    <CSpinner v-if="$data.loaders.create" variant="light" size="sm"/>
                    Save Subscription
                </CButton>
            </CModalFooter>
        </form>
    </CModal>
</template>
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, inject, onMounted, reactive, ref, watch } from 'vue';
import { cloneDeep, each, has, isEmpty, pick, set, unset } from 'lodash';
import { boolean, number, object, string } from 'yup';

const $data: any  = reactive({
    errors: {},
    form: {
        active:      Boolean(),
        default:     Boolean(),
        description: String(),
        features:    {
            can_comment:       false,
            max_posts:         Number(),
            for_businesses:    false,
            for_professionals: false   
        },
        name:  String(),
        price: Number()
    },
    isDisabled: false,
    loaders: {
        create: false
    }
});

const $toast: any = inject("$toast");

// Props
const $props = defineProps({
    flash: {
        type: Object,
        default: () => {}
    },    
    show: {
        type: Boolean,
        default: false,
    },
    subscription: {
        type: Object,
        default: () => {},
    },
});

// Initialize emits
const $emit = defineEmits(['update:show','fetch']);

const formSchema: any = computed( 
    () => object().shape({
        active:      boolean().required('*Status is required'),
        default:     boolean().required('*Default is required'),
        description: string().required("*Description is required"),
        name:        string().required("*Name is required"),
        features:    object().shape({
            max_posts:         number().required("*Max of posts is required"),
            for_businesses:    boolean().nullable(),
            for_professionals: boolean().nullable(),
            can_comment:       boolean().nullable()
        }),
        price:        number().required("*Price is required"),
    }) 
);

/**
 * Validates a form field based on the provided field name.
 * Uses the formSchema to validate the field and updates the errors object accordingly.
 * Updates the isDisabled property based on the presence of errors.
 *
 * @param {string} field - The name of the field to validate.
 */
const validateForm = async (form:any) => {
    try {
        // Validate the field using the formSchema
        await formSchema.value.validate(form,{ abortEarly: false, recursive: true});
        // Validated ite
        $data.errors  = {};
    } catch({ inner }:any){
        // Define data errors
        let data:any = {};
        // Walk through errors
        inner.forEach( ({ path, message }:any) => { data[path] = message });
        // If the field is invalid, update the errors object with the error message
        $data.errors = cloneDeep(data)
    } finally {
        // Update the isDisabled property based on the presence of errors
        $data.isDisabled = !isEmpty($data.errors);
    }
}


const showModal = computed({
    get: () => $props.show,
    set: (value:any) => $emit('update:show', value),
});

// Close modal and reset form
const closeModal = () => {
    showModal.value = false;
};

const resetForm = () => {
    $data.form =  {
        description: String(),
        features:    {
            max_posts: Number(),
            for_businesses: false,
            for_professionals: false            
        },
        name:  String(),
        price: Number()
    }
}

// Submit form to create new category
const submitForm = () => {
    $data.loaders.create = true;
    useForm($data.form).post(
        route('dashboard.subscriptions.update',{subscription: $props.subscription.id}), 
        {
            onSuccess: (value:any) => {
                $toast.success(value.props.flash.message);
                closeModal();
            },
        }
    );
};

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
    validateForm(form);
  },
  { 
    deep: true, // Set to true to observe nested properties
    immediate: true
  }
);

watch(
    () => $props.show,
    (value) => {
        if(value){ 
            let subscription = $props.subscription;

            console.log(subscription);
            if( !has(subscription.features,'for_businesses') ){
                set(subscription.features,'for_businesses',false)
            }

            if( !has(subscription.features,'for_professionals') ){
                set(subscription.features,'for_professionals',false)
            }            

            $data.form = pick(subscription,['active','default','features','name','price','description']); 
        }
        if(!value) { resetForm() }
    }
)
</script>

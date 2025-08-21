<template>
    <!-- Category Creation Modal -->
    <CModal
        :visible="showModal"
        @close="closeModal"
        alignment="center"
        title="Add New Category"
        backdrop="static"
    >
        <CModalHeader>
            <CModalTitle>Add Placement</CModalTitle>
        </CModalHeader>
        <form @submit.prevent="submitForm">
            <CModalBody>
                <CRow>
                    <CCol md="12" class="mb-2">                        
                        <CFormInput
                            id="name"
                            v-model="$data.form.name"
                            label="Name"
                            placeholder="Enter placement name"
                            :invalid="has($data.errors,'name') ? true : false"
                        />
                        <p v-show="has($data.errors,'name')" class="text-danger">{{ $data.errors.name }}</p>              
                    </CCol> 
                    <CCol md="12" class="mb-2"> 
                        <CFormSelect id="section" label="Section" v-model="$data.form.section">
                            <option>Open this select section</option>
                            <option :value="section.value" v-for="(section,index) in $data.sections" :key="index">{{ section.name }}</option>
                        </CFormSelect>                      
                        <p v-show="has($data.errors,'section')" class="text-danger">{{ $data.errors.section }}</p>            
                    </CCol> 
                    <CCol md="12"  class="mb-2">                        
                        <CFormInput
                            id="price"
                            v-model="$data.form.price"
                            label="Price"
                            placeholder="Enter price"
                            type="number"
                            :invalid="has($data.errors,'price') ? true : false"
                        />
                        <p v-show="has($data.errors,'price')" class="text-danger">{{ $data.errors.price }}</p>              
                    </CCol> 
                    <CCol md="12">                        
                        <CRow>                          
                            <CCol md="6">
                                <CFormInput
                                    id="custom.height"
                                    v-model.number="$data.form.custom.height"
                                    label="Height"
                                    placeholder="Enter height"
                                    type="number"
                                    min="240"
                                    :invalid="has($data.errors,'custom.height') ? true : false"
                                />
                                <p v-show="has($data.errors,'custom.height')" class="text-danger">{{ $data.errors['custom.height'] }}</p>              
                            </CCol> 
                            <CCol md="6">
                                <CFormInput
                                    id="custom.width"
                                    v-model.number="$data.form.custom.width"
                                    label="Width"
                                    placeholder="Enter width"
                                    type="number"
                                    min="480"
                                    :invalid="has($data.errors,'custom.width') ? true : false"
                                />
                                <p v-show="has($data.errors,'custom.width')" class="text-danger">{{ $data.errors['custom.width'] }}</p>              
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
                    Save Placement
                </CButton>
            </CModalFooter>
        </form>
    </CModal>
</template>
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { each, has, isEmpty, pick } from 'lodash';
import { computed, inject, reactive, watch } from 'vue';
import { number, object, string } from 'yup';

const $toast: any = inject("$toast");

const $data: any  = reactive({
    errors: {},
    form: {
        section: String(),
        name:    String(),
        price:   Number(),
        custom:  {
            height: Number(),
            width:  Number(),
        }
    },
    sections: [
        {
            name: 'Leader Banner',
            value: 'leader-banner'
        },
        {
            name: 'Top Banner',
            value: 'top-banner'
        },                
        {
            name: 'Advert',
            value: 'advert'
        },                     
    ],
    isDisabled: false,
    loaders: {
        create: false
    }   
})
// Props
const $props: any = defineProps({
    flash: {
        type: Object,
        default: () => {}
    },    
    show: {
        type: Boolean,
        default: false,
    },
    placement: {
        type: Object,
        default: () => {},
    },
});

// Initialize emits
const $emit = defineEmits(['update:show','fetch']);

const formSchema: any = computed( 
    () => object().shape({
        custom:  object().shape({
            height: number().typeError('Amount must be a number').min(240,"Minimum height is 240").required("*Height is required"),
            width:  number().typeError('Amount must be a number').min(480,"Minimum width is 480").required("*Width is required")
        }),        
        name:    string().required("*Name is required"),
        price:   number().required("*Price is required"),
        section: string().required("*Section is required"),
    }) 
);

/**
 * Validates a form field based on the provided field name.
 * Uses the formSchema to validate the field and updates the errors object accordingly.
 * Updates the isDisabled property based on the presence of errors.
 *
 * @param {string} field - The name of the field to validate.
 */
const validateForm = async (form:string) => {
    try {
        const valid_fields = await formSchema.value.validate(form);
        // Validate the field using the formSchema
        each(
            valid_fields,
            (value,key) => 
                value.constructor == Object ? 
                    each(value,(item,item_key) => delete $data.errors[`${key}.${item_key}`] ) : 
                        delete $data.errors[key] 
        )
    } catch(error: any) {
        // If the field is invalid, update the errors object with the error message
        $data.errors[error.path] = error.message;
    } finally {
        // Update the isDisabled property based on the presence of errors
        $data.isDisabled = !isEmpty($data.errors);
    }
}

/**
 * Resets the form data.
 *
 * Resets the form fields to their initial state (empty strings and empty objects).
 */
const resetForm = () => {
    $data.form =  {
        custom:  {
            height: Number(),
            width:  Number(),
        },        
        section: String(),
        name:    String(),
        price:   Number()
    }
    $data.errors = {}
}

const showModal = computed({
    get: () => $props.show,
    set: (value:any) => $emit('update:show', value),
});

// Close modal and reset form
const closeModal = () => {
    showModal.value = false;
};

// Submit form to create new category
const submitForm = () => {
    useForm($data.form).post(route('dashboard.placements.update',{placement: $props.placement.id}), {
        onSuccess: (value:any) => {
            $toast.success($props.flash.message);
            closeModal();
        },
    });
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
    if( $props.show ){
        validateForm(form); // Validate the individual form field
    }
  },
  { 
    deep: true, // Set to true to observe nested properties
    immediate: true
  }
);

watch(
    () => $props.show,
    (value) => {
        if(value){ $data.form = pick($props.placement,['custom','name','price','section']); }
        if(!value) { resetForm() }
    }
)
</script>

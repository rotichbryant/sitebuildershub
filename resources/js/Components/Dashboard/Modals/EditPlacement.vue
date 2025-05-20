<template>
    <!-- Category Creation Modal -->
    <CModal
        :visible="showModal"
        @close="closeModal"
        alignment="center"
        title="Add New Category"
    >
        <CModalHeader>
            <CModalTitle>Add Placement</CModalTitle>
        </CModalHeader>
        <form @submit.prevent="submitForm">
            <CModalBody>
                <CRow>
                    <CCol md="12">                        
                        <CFormInput
                            id="name"
                            v-model="$data.form.name"
                            label="Name"
                            placeholder="Enter placement name"
                            :invalid="has($data.errors,'name') ? true : false"
                        />
                        <p v-show="has($data.errors,'name')" class="text-danger">{{ $data.errors.name }}</p>              
                    </CCol> 
                    <CCol md="12"> 
                        <CFormSelect id="section" label="Section" v-model="$data.form.section">
                            <option>Open this select section</option>
                            <option :value="section.value" v-for="(section,index) in $data.sections" :key="index">{{ section.name }}</option>
                        </CFormSelect>                      
                        <p v-show="has($data.errors,'section')" class="text-danger">{{ $data.errors.section }}</p>            
                    </CCol> 
                    <CCol md="12">                        
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
        price:   Number()
    },
    sections: [
        {
            name: 'Home',
            value: 'home'
        },
        {
            name: 'Footer',
            value: 'footer'
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
 * Resets the form data.
 *
 * Resets the form fields to their initial state (empty strings and empty objects).
 */
const resetForm = () => {
    $data.form =  {
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
    () => $props.show,
    (value) => {
        if(value){ $data.form = pick($props.placement,['name','price','section']); }
        if(!value) { resetForm() }
    }
)
</script>

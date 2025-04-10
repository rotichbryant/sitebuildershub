<template>
    <!-- Category Creation Modal -->
    <CModal
        :visible="showModal"
        @close="closeModal"
        alignment="center"
        title="Add New Category"
    >
        <CModalHeader>
            <CModalTitle>Add New Child Sub Category</CModalTitle>
        </CModalHeader>
        <form @submit.prevent="submitForm">
            <CModalBody>
                <CCol md="12">
                    <CFormInput
                        id="name"
                        v-model="form.name"
                        label="Category Name"
                        placeholder="Enter category name"
                        :invalid="form.errors.name ? true : false"
                        required
                    />
                </CCol>
                <CCol md="12" class="mt-3">
                    <CFormSelect label="Select Category" v-model="form.category_id" required :invalid="form.errors.category_id ? true : false" @change="fetchSubCategories">
                        <option>Select Category</option>
                        <option :value="category.id" v-for="(category,index) in $props.categories" :key="index">{{ category.name }}</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12" class="mt-3">
                    <CFormSelect label="Select Category" v-model="form.sub_category_id" required :invalid="form.errors.sub_category_id ? true : false">
                        <option>Select Sub Category</option>
                        <option :value="sub_category.id" v-for="(sub_category,index) in $data.sub_categories" :key="index">{{ sub_category.name }}</option>
                    </CFormSelect>
                </CCol>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="closeModal">
                    Close
                </CButton>
                <CButton color="primary" type="submit" :disabled="form.processing">
                    <CSpinner v-if="form.processing" variant="light" size="sm"/>
                    Save Category
                </CButton>
            </CModalFooter>
        </form>
    </CModal>
</template>
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, inject, reactive } from 'vue';

const $toast: any = inject("$toast");

// Props
const $props: any = defineProps({
    categories: {
        type:    Array,
        default: () =>  Array(),
    },
    show: {
        type: Boolean,
        default: false,
    },
});

const $data: any = reactive({
    sub_categories: [],
});

// Initialize emits
const $emit = defineEmits(['update:show','fetch']);

const showModal = computed({
    get: () => $props.show,
    set: (value:any) => $emit('update:show', value),
});

// Form for creating new category
const form = useForm({
    name:            '',
    category_id:     '',
    sub_category_id: '',
});

// Close modal and reset form
const closeModal = () => {
    showModal.value = false;
    form.reset();
    form.clearErrors();
};

const fetchSubCategories = ($event: any) => {
    $data.sub_categories = $props.categories.find((category: any) => category.id == $event.target.value).sub_categories;
    form.sub_category_id = '';
};

// Submit form to create new category
const submitForm = () => {
    form.post(route('dashboard.child_sub_categories.store'), {
        onSuccess: (value:any) => {
            $emit('fetch');
            $toast.success(value.props.status);
            closeModal();
        }
    });
};
</script>

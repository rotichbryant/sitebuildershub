<template>
    <!-- Category Creation Modal -->
    <CModal
        :visible="showModal"
        @close="closeModal"
        alignment="center"
        title="Add New Category"
    >
        <CModalHeader>
            <CModalTitle>Add New Category</CModalTitle>
        </CModalHeader>
        <form @submit.prevent="submitForm">
            <CModalBody>
                <CAlert v-if="form.errors.name" color="danger">{{ form.errors.name }}</CAlert>
                <CFormInput
                    id="name"
                    v-model="form.name"
                    label="Category Name"
                    placeholder="Enter category name"
                    :invalid="form.errors.name ? true : false"
                    required
                />
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
import { computed, inject } from 'vue';

const $toast: any = inject("$toast");

// Props
const $props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

// Initialize emits
const $emit = defineEmits(['update:show','fetch']);

const showModal = computed({
    get: () => $props.show,
    set: (value:any) => $emit('update:show', value),
});
// Form for creating new category
const form = useForm({
    name: '',
});

// Close modal and reset form
const closeModal = () => {
    showModal.value = false;
    form.reset();
    form.clearErrors();
};

// Submit form to create new category
const submitForm = () => {
    form.post(route('dashboard.categories.store'), {
        onSuccess: (value:any) => {
            $emit('fetch');
            $toast.success(value.props.status);
            closeModal();
        },
    });
};
</script>

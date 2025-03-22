<template>
<AuthenticatedLayout>
    <Head title="Categories" />
    <CRow>
        <CCol xs="12">
        <CCard class="mb-4">
            <CCardBody> 
                <CRow>
                    <CCol md="6">
                        <h4>Sub Categories</h4>
                        <p class="text-muted">Manage your website categories to organize content effectively.</p>
                    </CCol>
                    <CCol md="6">
                        <CButton color="primary" class="float-end" @click="showModal = true">Add Child Category</CButton>
                    </CCol>
                </CRow>
                <CTable>
                    <CTableHead>
                        <CTableRow>
                        <CTableHeaderCell scope="col">#</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Name</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Category</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Child Sub Categories</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Created On</CTableHeaderCell>
                        <CTableHeaderCell scope="col"></CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-if="isEmpty($data.sub_categories.data)">
                            <CTableDataCell colspan="6" class="text-center">
                                <h6 class="mb-0"><CIcon name="cil-exclamation-circle"/> Nothing Found Here. </h6>
                            </CTableDataCell>
                        </CTableRow>
                        <CTableRow v-for="(sub_category, index) in $data.sub_categories.data" :key="sub_category.id">
                            <CTableDataCell scope="row">{{ index + 1 }}</CTableDataCell>
                            <CTableDataCell>{{ sub_category.name }}</CTableDataCell>
                            <CTableDataCell><CBadge color="primary">{{ sub_category.category.name }}</CBadge></CTableDataCell>
                            <CTableDataCell><CBadge color="primary">{{ sub_category.child_sub_categories_count }}</CBadge></CTableDataCell>
                            <CTableDataCell>{{ sub_category.created_at }}</CTableDataCell>
                            <CTableDataCell>
                                <CDropdown>
                                    <CDropdownToggle color="link" :caret="false" class="p-0"><CIcon name="cil-options" /></CDropdownToggle>
                                    <CDropdownMenu>
                                        <CDropdownItem href="#" @click="$edit(sub_category)">Edit</CDropdownItem>
                                        <CDropdownItem href="#" @click="$delete(sub_category)">Delete</CDropdownItem>
                                    </CDropdownMenu>
                                </CDropdown>
                            </CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
                <CCol md="12">
                    <CPagination aria-label="Page navigation example" size="sm" align="center">
                        <CPaginationItem :href="page.url" v-for="(page, index) in pages" :key="index" :active="page.active"><span v-html="page.label"></span></CPaginationItem>
                    </CPagination>         
                </CCol>
            </CCardBody>
        </CCard>
        </CCol>
    </CRow>
    <AddSubCategory 
        :categories="$props.categories"
        :show="showModal" 
        @update:show="showModal = $event"
        @fetch="$fetch"
    />
</AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { AddSubCategory } from '@/Components/Dashboard';
import { computed, onMounted, reactive, ref } from 'vue';
import { CTableDataCell } from '@coreui/vue';
import { isEmpty, isNull } from 'lodash';

// Modal visibility state
const showModal = ref(false);

// In your Vue component
const $props: any = defineProps({
    categories:     Array,
    sub_categories: Object,
    status:         String
});

const $data: any = reactive({
    sub_categories: {},
    loaders: {
        fetch: false
    }
})

const pages = computed( () => !isEmpty($data.sub_categories) ? $data.sub_categories.links.filter( (link: any) => !isNull(link.url)) : [] );

/**
 * Fetch categories from the server.
 * @async
 * @function
 * @name $fetch
 * @returns {Promise<void>}
 */
const $fetch = async () => {
    try {
        // Set the loading flag
        $data.loaders.fetch = true;

        // Fetch the categories from the server
        const { data }: any = await router.get(route('dashboard.sub_categories'));

        // Set the categories
        $data.sub_categories = data;
    } catch (error) {
        // Set the loading flag
        $data.loaders.fetch = false;

        // Log the error
        console.error('Error fetching categories', error);
    } finally {
        // Set the loading flag
        $data.loaders.fetch = false;
    }
}

const $delete = (value) => {

}

const $edit = (value) => {

}

onMounted( () => {
    $data.sub_categories = $props.sub_categories
})
</script>

<template>
<AuthenticatedLayout>
    <Head title="Categories" />
    <CRow>
        <CCol xs="12">
        <CCard class="mb-4">
            <CCardBody> 
                <CRow>
                    <CCol md="6">
                        <h4>Categories</h4>
                        <p class="text-muted">Manage your website categories to organize content effectively.</p>
                    </CCol>
                    <CCol md="6">
                        <CButton color="primary" class="float-end" @click="showModal = true">Add Category</CButton>
                    </CCol>
                </CRow>
                <CTable>
                    <CTableHead>
                        <CTableRow>
                        <CTableHeaderCell scope="col">#</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Name</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Sub Categories</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Child Sub Categories</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Created On</CTableHeaderCell>
                        <CTableHeaderCell scope="col"></CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-for="(category, index) in $data.categories.data" :key="category.id">
                            <CTableHeaderCell scope="row">{{ (index + 1) }}</CTableHeaderCell>
                            <CTableDataCell>{{ category.name }}</CTableDataCell>
                            <CTableDataCell><CBadge color="primary">{{ category.sub_categories_count }}</CBadge></CTableDataCell>
                            <CTableDataCell><CBadge color="primary">{{ category.sub_categories_count }}</CBadge></CTableDataCell>
                            <CTableDataCell>{{ category.created_at }}</CTableDataCell>
                            <CTableDataCell>
                                <CDropdown>
                                    <CDropdownToggle color="link" :caret="false" class="p-0"><CIcon name="cil-options" /></CDropdownToggle>
                                    <CDropdownMenu>
                                        <CDropdownItem href="#" @click="$edit(category)">Edit</CDropdownItem>
                                        <CDropdownItem href="#" @click="$delete(category)">Delete</CDropdownItem>
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
    <AddCategory 
        :show="showModal" 
        @update:show="showModal = $event"
        @fetch="$fetch"
    />
</AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { AddCategory } from '@/Components/Dashboard';
import { computed, onMounted, reactive, ref } from 'vue';
import { CTableDataCell, CTableFoot } from '@coreui/vue';
import { isEmpty, isNull } from 'lodash';

// Modal visibility state
const showModal = ref(false);

// In your Vue component
const $props = defineProps({
    categories: Object,
    status: String
});

const pages = computed( () => !isEmpty($data.categories) ?$data.categories.links.filter( (link: any) => !isNull(link.url)) : [] );

const $data = reactive({
    categories: Object(),
    loaders: {
        fetch: false
    }
})

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
        const { data }: any = await router.get(route('dashboard.categories'));

        // Set the categories
        $data.categories = data;
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

const $delete = (value:any) => {

}

const $edit = (value:any) => {

}

onMounted( () => {
    $data.categories = $props.categories
})
</script>

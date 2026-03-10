<template>
<AuthenticatedLayout>
    <Head title="Advert Placement" />
    <CRow>
        <CCol md="6">
            <h4>Advert Placements</h4>
            <p class="text-muted">This section specifies areas where adverts can be placed and how much those sections cost.</p>
        </CCol>
        <CCol md="6">
            <CButton color="primary" class="float-end" @click="showModal = true">Create placement</CButton>
        </CCol>                    
    </CRow>    
    <CRow>
        <CCol xs="12">
        <CCard class="mb-4 border-0 shadow-sm">
            <CCardBody> 
                <CTable>
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell scope="col">#</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Name</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Price</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Section</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Adverts</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Created On</CTableHeaderCell>
                            <CTableHeaderCell scope="col"></CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                      <CTableRow v-if="isEmpty($props.placements.data)">
                            <CTableDataCell colspan="7" class="text-center">
                                <h6 class="mb-0"><CIcon name="cil-exclamation-circle"/> Nothing Found Here. </h6>
                            </CTableDataCell>
                        </CTableRow>
                        <CTableRow v-for="(placement, index) in $props.placements.data" :key="placement.id">
                            <CTableHeaderCell scope="row">{{ (index + 1) }}</CTableHeaderCell>
                            <CTableDataCell>{{ placement.name }}</CTableDataCell>
                            <CTableDataCell>{{ placement.currency_price }}</CTableDataCell>
                            <CTableDataCell><CBadge color="info" class="p-2">{{ placement.section }}</CBadge></CTableDataCell>
                            <CTableDataCell>{{ placement.promotions_count }}</CTableDataCell>
                            <CTableDataCell>{{ moment(placement.created_at).format('MMMM Do YYYY') }}</CTableDataCell>
                            <CTableDataCell>
                                <CDropdown>
                                    <CDropdownToggle color="link" :caret="false" class="p-0"><CIcon name="cil-options" /></CDropdownToggle>
                                    <CDropdownMenu>
                                        <CDropdownItem href="#" @click="$edit(placement)">Edit</CDropdownItem>
                                        <CDropdownItem href="#" @click="$delete(placement)">Delete</CDropdownItem>
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
                <AddPlacement 
                  :show="showModal" 
                  :flash="$props.flash"                  
                  @update:show="showModal = $event"
                />
                <EditPlacement 
                  :show="editModal" 
                  :placement="$data.placement"
                  :flash="$props.flash"
                  @update:show="editModal = $event"
                />                
            </CCardBody>
        </CCard>
        </CCol>
    </CRow>
</AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed, inject, onMounted, reactive, ref, watch } from 'vue';
import { CTableDataCell } from '@coreui/vue';
import { cloneDeep, has, isEmpty, isNull } from 'lodash';
import { AddPlacement, EditPlacement } from '@/Components/Dashboard';
import moment from 'moment';

// Modal visibility state
const showModal = ref(false);
const editModal = ref(false);

// In your Vue component
const $props: any = defineProps({
    flash:      Object,    
    placements: Object,
    data:       Object
});

const $swal: any  = inject('$swal');  
const $toast: any = inject('$toast');  

const $data: any = reactive({
  placement: {},
  loaders: {
    fetch: false
  },
  modal: false,
});

const pages = computed( () => !isEmpty($props.clients) ? $props.clients.links.filter( (link: any) => !isNull(link.url)) : [] );

/**
 * Fetch categories from the server.
 * @async
 * @function
 * @name $fetch
 * @returns {Promise<void>}
 */
const $edit = async (placement: any) => {
    $data.placement = cloneDeep(placement);
    editModal.value    = true;
}

const $delete = async (value:any) => {
    // Show a confirmation dialog to the user
    const { isConfirmed } = await $swal.fire({
        icon:  'question', // Icon to display in the dialog
        title: 'Delete placement', // Title of the dialog
        text:  `Are you sure you want to delete ${value.name}?`, // Text content of the dialog
        showCancelButton: true // Whether to show a "Cancel" button
    });

    // If the user does not confirm, exit the function
    if (!isConfirmed) { return; }
            
    // Set the loading flag
    $data.loaders.fetch = true;

    // Fetch the categories from the server
    router.delete(
        route('dashboard.placements.delete',{ placement: value.id }),
        {
            onSuccess: () => {
                // Post message
                $toast.success($props.flash.message);   
            },
            onError: (error) => {
                // Set the loading flag
                $data.loaders.fetch = false;
            }
        }
    );
}

onMounted( () => {
  $data.placements = $props.placements
})
</script>

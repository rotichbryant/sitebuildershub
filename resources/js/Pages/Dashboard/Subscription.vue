<template>
<AuthenticatedLayout>
    <Head title="Subscriptions" />
    <CRow>
        <CCol xs="12">
        <CCard class="mb-4">
            <CCardBody> 
                <CRow>
                    <CCol md="6">
                        <h4>Subscriptions</h4>
                        <p class="text-muted">This page shows a list of all subscriptions on the platform. You can view the subscription details and search for specific subscriptions using the search bar.</p>
                    </CCol>
                    <CCol md="6">
                        <CButton color="primary" class="float-end" @click="showModal = true">Create Subscription</CButton>
                    </CCol>                    
                </CRow>
                <CTable>
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell scope="col">#</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Name</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Price</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Users</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Status</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Default</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Created On</CTableHeaderCell>
                            <CTableHeaderCell scope="col"></CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                      <CTableRow v-if="isEmpty($props.subscriptions.data)">
                            <CTableDataCell colspan="7" class="text-center">
                                <h6 class="mb-0"><CIcon name="cil-exclamation-circle"/> Nothing Found Here. </h6>
                            </CTableDataCell>
                        </CTableRow>
                        <CTableRow v-for="(subscription, index) in $props.subscriptions.data" :key="subscription.id">
                            <CTableHeaderCell scope="row">{{ (index + 1) }}</CTableHeaderCell>
                            <CTableDataCell>{{ subscription.name }}</CTableDataCell>
                            <CTableDataCell>{{ subscription.currency_price }}</CTableDataCell>
                            <CTableDataCell>{{ subscription.users_count }}</CTableDataCell>
                            <CTableDataCell>
                              <CBadge color="success" class="p-2" v-if="subscription.active">Active</CBadge>
                              <CBadge color="warning" class="p-2" v-if="!subscription.active">Inactive</CBadge>
                            </CTableDataCell>
                            <CTableDataCell >
                              <CIcon name="cil-check" class="text-success" v-if="subscription.default" />
                              <CIcon name="cil-x-circle" class="text-danger"  v-if="!subscription.default" />
                            </CTableDataCell>
                            <CTableDataCell>{{ moment(subscription.created_at).format('MMMM Do YYYY') }}</CTableDataCell>
                            <CTableDataCell>
                                <CDropdown>
                                    <CDropdownToggle color="link" :caret="false" class="p-0"><CIcon name="cil-options" /></CDropdownToggle>
                                    <CDropdownMenu>
                                        <CDropdownItem href="#" @click="$edit(subscription)">Edit</CDropdownItem>
                                        <CDropdownItem href="#" @click="$delete(subscription)">Delete</CDropdownItem>
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
                <AddSubscription 
                  :show="showModal" 
                  :flash="$props.flash"                  
                  @update:show="showModal = $event"
                />
                <EditSubscription 
                  :show="editModal" 
                  :subscription="$data.subscription"
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
import { AddSubscription, EditSubscription } from '@/Components/Dashboard';
import moment from 'moment';

// Modal visibility state
const showModal = ref(false);
const editModal = ref(false);

// In your Vue component
const $props: any = defineProps({
    flash:         Object,    
    subscriptions: Object,
    data:          Object
});

const $swal: any  = inject('$swal');  
const $toast: any = inject('$toast');  

const $data: any = reactive({
  subscription: {},
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
const $edit = async (subscription: any) => {
    $data.subscription = cloneDeep(subscription);
    editModal.value    = true;
}

const $delete = async (value:any) => {
    // Show a confirmation dialog to the user
    const { isConfirmed } = await $swal.fire({
        icon:  'question', // Icon to display in the dialog
        title: 'Delete Subscription', // Title of the dialog
        text:  `Are you sure you want to delete ${value.name}?`, // Text content of the dialog
        showCancelButton: true // Whether to show a "Cancel" button
    });

    // If the user does not confirm, exit the function
    if (!isConfirmed) { return; }
            
    // Set the loading flag
    $data.loaders.fetch = true;

    // Fetch the categories from the server
    router.delete(
        route('dashboard.subscriptions.delete',{ subscription: value.id }),
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
  $data.subscriptions = $props.subscription
})
</script>

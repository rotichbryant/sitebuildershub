<template>
<AuthenticatedLayout>
    <Head title="Transactions" />
    <CRow>
        <CCol xs="12">
        <CCard class="mb-4">
            <CCardBody> 
                <CRow>
                    <CCol md="6">
                        <h4>Transactions</h4>
                        <p class="text-muted">This page shows a list of all transactions on the platform. You can view the transaction details and search for specific transactions using the search bar.</p>
                    </CCol>
                </CRow>
                <CTable>
                    <CTableHead>
                        <CTableRow>
                        <CTableHeaderCell scope="col">#</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Reference</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Amount</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Item</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Status</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Created On</CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                      <CTableRow v-if="isEmpty($props.transactions.data)">
                            <CTableDataCell colspan="7" class="text-center">
                                <h6 class="mb-0"><CIcon name="cil-exclamation-circle"/> Nothing Found Here. </h6>
                            </CTableDataCell>
                        </CTableRow>
                        <CTableRow v-for="(transaction, index) in $props.transactions.data" :key="transaction.id">
                            <!-- <CTableHeaderCell scope="row">{{ (index + 1) }}</CTableHeaderCell>
                            <CTableDataCell>{{ client.name }}</CTableDataCell>
                            <CTableDataCell>{{ client.email }}</CTableDataCell>
                            <CTableDataCell>{{ client.phone_number }}</CTableDataCell>
                            <CTableDataCell>
                              <CBadge color="success" v-if="!isNull(client.email_verified_at)">Active</CBadge>
                              <CBadge color="warning" v-if="isNull(client.email_verified_at)">Inactive</CBadge>
                            </CTableDataCell>
                            <CTableDataCell>{{ client.created_at }}</CTableDataCell>
                            <CTableDataCell>
                                <CDropdown>
                                    <CDropdownToggle color="link" :caret="false" class="p-0"><CIcon name="cil-options" /></CDropdownToggle>
                                    <CDropdownMenu>
                                        <CDropdownItem href="#">Edit</CDropdownItem>
                                        <CDropdownItem href="#">Delete</CDropdownItem>
                                    </CDropdownMenu>
                                </CDropdown>
                            </CTableDataCell> -->
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
</AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, onMounted, reactive, ref } from 'vue';
import { CTableDataCell, CTableFoot } from '@coreui/vue';
import { isEmpty, isNull } from 'lodash';

// In your Vue component
const $props: any = defineProps({
  transactions: Object,
});

const pages = computed( () => !isEmpty($props.clients) ? $props.clients.links.filter( (link: any) => !isNull(link.url)) : [] );
</script>

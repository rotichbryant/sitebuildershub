<template>
  <AuthenticatedLayout>
    <Head title="Transactions" />
    <CCard>
        <CCardBody>
            <CRow>
            <CCol xs="12">
                <CRow>
                    <CCol md="6">
                        <h4>Transactions</h4>
                        <p class="text-muted">View transactions made by users for subscriptions and adverts.</p>
                    </CCol>
                </CRow>
            </CCol>
            <CCol xs="12">
                <CTable>
                    <CTableHead>
                        <CTableRow>
                        <CTableHeaderCell scope="col">#</CTableHeaderCell>
                        <CTableHeaderCell scope="col">User</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Reference</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Payment Method</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Amount</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Status</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Paid On</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Created On</CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-if="isEmpty($props.transactions.data)">
                            <CTableDataCell colspan="7" class="text-center">
                                <h6 class="mb-0"><CIcon name="cil-exclamation-circle"/> Nothing Found Here. </h6>
                            </CTableDataCell>
                        </CTableRow>
                        <Deferred data="transactions">
                            <template #fallback>
                                <div>Loading...</div>
                            </template>
                            <CTableRow v-for="(transaction, index) in $props.transactions.data" :key="transaction.id">
                                <CTableHeaderCell scope="row">{{ (index + 1) }}</CTableHeaderCell>
                                <CTableDataCell><CAvatar color="primary" text-color="white">{{ transaction.user.name[0] }}</CAvatar> {{ transaction.user.name }}</CTableDataCell>
                                <CTableDataCell>{{ transaction.confirmation_code }}</CTableDataCell>
                                <CTableDataCell>{{ transaction.payment_method }}</CTableDataCell>
                                <CTableDataCell>{{ transaction.currency }} {{ transaction.amount }}</CTableDataCell>
                                <CTableDataCell>
                                    <CBadge color="success" v-if="!isNull(transaction.complete)">Complete</CBadge>
                                 <CBadge color="warning" v-if="isNull(transaction.complete)">Pending</CBadge>
                                </CTableDataCell>
                                <CTableDataCell>{{ transaction.paid_at }}</CTableDataCell>
                                <CTableDataCell>{{ transaction.created_at }}</CTableDataCell>
                            </CTableRow>                    
                        </Deferred>                
                    </CTableBody>
                </CTable>
                <CCol md="12">
                    <CPagination aria-label="Page navigation example" size="sm" align="center">
                        <CPaginationItem :href="page.url" v-for="(page, index) in pages" :key="index" :active="page.active"><span v-html="page.label"></span></CPaginationItem>
                    </CPagination>         
                </CCol>
            </CCol>
            </CRow>            
        </CCardBody>
    </CCard>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Posting } from '@/Components/Dashboard';
import { Deferred, Head } from '@inertiajs/vue3';
import { isEmpty, isNull } from 'lodash';
import { computed, inject } from 'vue';
import { CCardBody, CCardTitle, CCol } from '@coreui/vue';

const $swal: any  = inject('$swal');  
const $toast: any = inject('$toast');  

// In your Vue component
const $props: any = defineProps({
    transactions: Object,
});

const pages = computed( () => !isEmpty($props.transactions) ?$props.transactions.links.filter( (link: any) => !isNull(link.url)) : [] );


</script>
  
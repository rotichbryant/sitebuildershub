<template>
<AuthenticatedLayout>
    <Head title="Clients" />
    <CRow>
        <CCol xs="12">
        <CCard class="mb-4">
            <CCardBody> 
                <CRow>
                    <CCol md="6">
                        <h4>Clients</h4>
                        <p class="text-muted">View and manage client details and information</p>
                    </CCol>
                </CRow>
                <CTable>
                    <CTableHead>
                        <CTableRow>
                        <CTableHeaderCell scope="col">#</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Name</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Email</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Phone Number</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Verified</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Joined On</CTableHeaderCell>
                        <CTableHeaderCell scope="col"></CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                      <CTableRow v-if="isEmpty($props.clients.data)">
                            <CTableDataCell colspan="7" class="text-center">
                                <h6 class="mb-0"><CIcon name="cil-exclamation-circle"/> Nothing Found Here. </h6>
                            </CTableDataCell>
                        </CTableRow>
                        <CTableRow v-for="(client, index) in $props.clients.data" :key="client.id">
                            <CTableHeaderCell scope="row">{{ (index + 1) }}</CTableHeaderCell>
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
  clients: Object,
  status: String
});

const pages = computed( () => !isEmpty($props.clients) ? $props.clients.links.filter( (link: any) => !isNull(link.url)) : [] );
</script>

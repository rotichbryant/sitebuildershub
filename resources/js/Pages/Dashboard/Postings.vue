<template>
  <AuthenticatedLayout>
    <Head title="Postings" />
    <CRow>
      <CCol xs="12">
        <CRow>
            <CCol md="6">
                <h4>Postings</h4>
                <p class="text-muted">Manage your website categories to organize content effectively.</p>
            </CCol>
        </CRow>
      </CCol>
      <CCol xs="12">
        <CRow>
          <Deferred data="postings">
              <template #fallback>
                  <div>Loading...</div>
              </template>
              <template v-if="isEmpty($props.postings.data)">
                <CCol md="12">
                  <CCard class="border-primary">
                    <CCardBody class="p-5">
                      <CCardTitle class="text-center"><CIcon name="cil-exclamation-circle"/>No postings found</CCardTitle>
                    </CCardBody>
                  </CCard>
                </CCol>
              </template>
              <template v-if="!isEmpty($props.postings.data)" v-for="(posting,index) in $props.postings.data" :key="posting.id">
                  <Posting :data="posting" />
              </template>
          </Deferred>
        </CRow>
      </CCol>
      <CCol md="12" class="mt-3" v-if="!isEmpty($props.postings.data)">
          <CPagination aria-label="Page navigation example" size="sm" align="center">
              <CPaginationItem :href="page.url" v-for="(page, index) in pages" :key="index" :active="page.active"><span v-html="page.label"></span></CPaginationItem>
          </CPagination>         
      </CCol>
    </CRow>
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
    postings: Object,
    status: String
});

const pages = computed( () => !isEmpty($props.postings) ?$props.postings.links.filter( (link: any) => !isNull(link.url)) : [] );


</script>
  
<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="wrapper min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
        <CRow class="justify-content-center">
            <CCol md="12" xs="12">
                <Link href="/">
                    <!-- <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" /> -->
                </Link>
            </CCol>
            <slot />
        </CRow>
    </CContainer>
  </div>        
</template>

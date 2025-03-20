<template>
    <AuthenticatedLayout>
        <Head title="System | Dashboard" />
        <CRow>
            <CCol md="12">
                <h3>System</h3>
                <p>Mail Settings, Payment Gateway, App Logo and Icon.</p>
            </CCol>
            <CCol md="12"> 
                <CRow>
                    <CCol md="10">
                        <LogoIconTab />
                        <MailTab />
                        <!-- <PaymentTab /> -->
                    </CCol>
                    <CCol md="2">
                        <CNav class="flex-column position-fixed" variant="underline">
                            <CNavItem>
                                <CNavLink href="#logo-icon" class="py-0"> App Logo & Icon </CNavLink>
                            </CNavItem>
                            <CNavItem>
                                <CNavLink href="#mail" class="py-0"> Mail Settings </CNavLink>
                            </CNavItem>
                            <CNavItem>
                                <CNavLink href="#payment" class="py-0"> Payment Gateway </CNavLink>
                            </CNavItem>
                        </CNav>
                    </CCol>
                </CRow>
            </CCol>
        </CRow>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { LogoIconTab, MailTab, PaymentTab } from '@/Components/Dashboard';
</script>
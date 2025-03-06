<template>
    <LandingLayout>
        <CRow>
            <CCol md="12" class="p-0">
                <CCard class="bg-info bg-opacity-10 border-0">
                    <CCardBody>
                        <CContainer lg class="p-5">
                            <CRow class="p-5">
                                <CCol md="12">
                                    <h3 class="text-center">What are you looking for?</h3>
                                </CCol>
                                <CCol md="12">
                                    <CForm>
                                        <CRow>
                                            <CCol md="2">
                                                <CFormSelect aria-label="Default select example">
                                                    <option>Location</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3" disabled>Three</option>
                                                </CFormSelect>
                                            </CCol>
                                            <CCol md="8">
                                                <CFormInput
                                                    type="text"
                                                    placeholder="Search by name"
                                                />
                                            </CCol>
                                            <CCol md="2">
                                                <CButton color="primary" class="w-100">Search</CButton>
                                            </CCol>
                                        </CRow>
                                    </CForm>
                                </CCol>
                            </CRow>
                        </CContainer>
                    </CCardBody>
                </CCard>
            </CCol>
        </CRow>
    </LandingLayout>
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
</script>
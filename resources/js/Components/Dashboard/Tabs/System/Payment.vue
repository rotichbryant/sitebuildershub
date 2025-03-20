<template>
    <CCard class="mb-4" id="payment">
        <CCardBody>
            <CCol :md="12">
                <CCol :md="4 ">
                    <CFormInput
                        type="email"
                        label="Mail Host"
                        class="mb-2"
                    />  
                    <CFormInput
                        type="email"
                        label="Mail Username"
                        class="mb-2"
                    />  
                    <CFormInput
                        type="email"
                        label="Mail Password"
                        class="mb-2"
                    />  
                    <CFormInput
                        type="number"
                        label="Mail Port"
                    />       
                </CCol>          
            </CCol>  
        </CCardBody>
    </CCard>    
</template>
<template>
    <AuthenticatedLayout>
      <CRow>
        <CCol :xs="12">
          <CCard class="mb-4">
            <CCardHeader>
              <strong>Mail Box</strong>
            </CCardHeader>
            <CCardBody> 
                <CRow>
                    <CCol md="12" xs="12" class="d-flex justify-content-end mb-4">
                    </CCol>
                    <CCol md="3 " xs="12">
                        <CNav variant="underline-border" class="flex-column">
                            <CNavItem>
                                <CNavLink href="#">Inbox</CNavLink>
                            </CNavItem>
                            <CNavItem>
                                <CNavLink href="#">Sent Items</CNavLink>
                            </CNavItem>
                            <CNavItem>
                                <CNavLink href="#">Junk</CNavLink>
                            </CNavItem>
                        </CNav>
                    </CCol>
                    <CCol md="9" xs="12" style="height: 75vh;">
                        <CCol md="12" xs="12" class="d-flex justify-content-between mb-3">
                            <CButtonGroup role="group" aria-label="Basic outlined example">
                                <CButton color="warning" variant="outline"><CIcon icon="cil-thumb-down" /></CButton>
                                <CButton color="success" variant="outline"><CIcon icon="cil-star" /></CButton>
                                <CButton color="danger" variant="outline"><CIcon icon="cil-trash" /></CButton>
                            </CButtonGroup>
                            <CButtonGroup role="group">
                                <CButton color="primary" variant="outline"><CIcon icon="cil-chevron-left" /></CButton>
                                <CButton color="primary" variant="outline"><CIcon icon="cil-chevron-right" /></CButton>
                            </CButtonGroup>
                            <CButtonGroup role="group">
                                <CButton @click="$data.modals.account = true" color="primary" variant="outline"><CIcon icon="cil-plus" /></CButton>
                                <CButton @click="$data.modals.compose = true" color="primary" variant="outline"><CIcon icon="cil-envelope-closed" /></CButton>
                            </CButtonGroup>
                        </CCol>
                        <CListGroup>
                            <CListGroupItem as="a" href="#">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">List group item heading</h5>
                                    <small>3 days ago</small>
                                </div>
                                <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                <small>Donec id elit non mi porta.</small>
                            </CListGroupItem>
                        </CListGroup>
                    </CCol>
                </CRow>
                <CModal alignment="center" size="lg" :keyboard="false" :visible="$data.modals.compose" @close="$data.modals.compose = !$data.modals.compose">
                    <CModalHeader>
                        <CModalTitle>Compose a new message</CModalTitle>
                    </CModalHeader>
                    <CModalBody>
                        <CRow>
                            <CCol md="6" xs="12">
                                <CFormInput label="To" v-model="sendmail.email_to"/>
                            </CCol>
                            <CCol md="6" xs="12">
                                <CFormInput label="From" v-model="sendmail.email_from"/>
                            </CCol>
                            <CCol md="12" xs="12">
                                <CFormInput label="Subject" v-model="sendmail.subject"/>
                            </CCol>
                            <CCol md="12" xs="12">
                                <CFormTextarea label="Message" v-model="sendmail.message" rows="10"/>
                            </CCol>
                        </CRow>
                    </CModalBody>
                    <CModalFooter class="d-flex justify-content-between">
                        <CButton color="secondary" @click="$data.modals.compose = false">Cancel</CButton>
                        <CButton color="primary">Send</CButton>
                    </CModalFooter>
                </CModal>
                <CModal alignment="center" size="lg" :keyboard="false" :visible="$data.modals.account" @close="$data.modals.account = !$data.modals.account">
                    <CModalHeader>
                        <CModalTitle>Add New Email Account</CModalTitle>
                    </CModalHeader>
                    <CForm @submit.prevent="addAccount">
                        <CModalBody>
                            <CRow>
                                <CCol md="6" xs="12">
                                    <CRow>
                                        <CCol md="12" xs="12">
                                            <h6>Incoming Mail(IMAP)</h6>
                                        </CCol>
                                        <CCol md="12" xs="12">
                                            <CFormInput label="Server" v-model="account.incoming_server" :class="account.errors.incoming_server ? 'border-danger' : 'border-secondary'"/>
                                            <p class="text-danger" v-if="account.errors.incoming_server">{{ account.errors.incoming_server }} </p>
                                        </CCol> 
                                        <CCol md="12" xs="12">
                                            <CFormSelect label="Encryption" v-model="account.incoming_encryption" :class="account.errors.incoming_encryption ? 'border-danger' : 'border-secondary'">
                                                <option>Select Encryption Type</option>
                                                <option value="ssl">SSL</option>
                                                <option value="tls">TLS</option>
                                            </CFormSelect>
                                            <p class="text-danger" v-if="account.errors.incoming_encryption">{{ account.errors.incoming_encryption }} </p>
                                        </CCol>
                                        <CCol md="12" xs="12">
                                            <CFormInput label="Port" type="number" v-model.number="account.incoming_port" :class="account.errors.incoming_port ? 'border-danger' : 'border-secondary'"/>
                                            <p class="text-danger" v-if="account.errors.incoming_port">{{ account.errors.incoming_port }} </p>
                                        </CCol>                                   
                                    </CRow>
                                </CCol>
                                <CCol md="6" xs="12">
                                    <CRow>
                                        <CCol md="12" xs="12">
                                            <h6>Outgoing Mail(SMTP)</h6>
                                        </CCol>
                                        <CCol md="12" xs="12">
                                            <CFormInput label="Server" v-model="account.outgoing_server" :class="account.errors.outgoing_server ? 'border-danger' : 'border-secondary'"/>
                                            <p class="text-danger" v-if="account.errors.outgoing_server">{{ account.errors.outgoing_server }} </p>
                                        </CCol>  
                                        <CCol md="12" xs="12">
                                            <CFormSelect label="Encryption" v-model="account.outgoing_encryption" :class="account.errors.outgoing_encryption ? 'border-danger' : 'border-secondary'">
                                                <option>Select Encryption Type</option>
                                                <option value="ssl">SSL</option>
                                                <option value="tls">TLS</option>
                                            </CFormSelect>
                                            <p class="text-danger" v-if="account.errors.outgoing_encryption">{{ account.errors.outgoing_encryption }} </p>
                                        </CCol>
                                        <CCol md="12" xs="12">
                                            <CFormInput label="Port" type="number" v-model.number="account.outgoing_port" :class="account.errors.outgoing_port ? 'border-danger' : 'border-secondary'"/>
                                            <p class="text-danger" v-if="account.errors.outgoing_port">{{ account.errors.outgoing_port }} </p>
                                        </CCol>                                  
                                    </CRow>
                                </CCol>
                                <CCol md="12" xs="12" class="my-2">
                                    <CCol md="12" xs="12">
                                        <h6>Account Details</h6>
                                    </CCol>
                                    <CRow>
                                        <CCol md="6" xs="12">
                                            <CFormInput label="Username/Email" name="mail_username" v-model="account.username" :class="account.errors.username ? 'border-danger' : 'border-secondary'"/>
                                            <p class="text-danger" v-if="account.errors.username"> {{ account.errors.username }} </p>
                                        </CCol>
                                        <CCol md="6" xs="12">
                                            <CFormInput label="Password" type="password" name="mail_password" v-model="account.password" :class="account.errors.password ? 'border-danger' : 'border-secondary'"/>
                                            <p class="text-danger" v-if="account.errors.password">{{ account.errors.password }} </p>
                                        </CCol>
                                    </CRow>
                                </CCol>
                            </CRow>
                    </CModalBody>
                    <CModalFooter class="d-flex justify-content-between">
                        <CButton color="secondary" @click="$data.modals.account = false">Cancel</CButton>
                        <CButton color="primary" type="submit" :disabled="account.processing">
                            <CSpinner v-if="account.processing" size="sm"/>
                            Save 
                        </CButton>
                    </CModalFooter>
                </CForm>
                </CModal>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </AuthenticatedLayout>
</template>
  
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted,reactive } from 'vue';
import { useForm, usePoll  } from '@inertiajs/vue3';
import { CForm, CFormTextarea } from '@coreui/vue';
import axios from 'axios';

const { accounts } = defineProps<{
    accounts?: any
}>();

const $data = reactive({
    active_account: String(),
    emails:         Array(),
    mailboxes:      Array(),
    modals:         { account: false, compose: false },
});

const sendmail = useForm({
    attamentes: Array(),
    email_to:   String(),
    email_from: String(),
    subject:    String(),
    message:    String(),
});

const fetchMailbox = async (id: String) =>  {
    try{
        let { data: { mailboxes} } = await axios.post(`/mail/${id}`);
        $data.mailboxes = mailboxes;
    } catch (error) {
        console.log(error);
    }
}

const account = useForm({
    incoming_encryption: String(),
    incoming_port:       Number(),
    incoming_server:     String(),
    outgoing_encryption: String(),
    outgoing_port:       Number(),
    outgoing_server:     String(),
    password:            String(),
    username:            String(),
});

const addAccount = () => {
    account.post('/mail',{
        onFinish: () => {
            $data.modals.account = false
            account.reset();
        },
    })
}

// onMounted(accounts.length > 0 ? fetchMailbox(accounts[0].id) : () => {})

</script>
    
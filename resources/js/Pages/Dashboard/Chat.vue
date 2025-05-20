<template>
    <AuthenticatedLayout>
        <Head title="Chat | Dashboard" />
        <CRow>
            <CCol md="12">
                <h4>Chat</h4>
                <p class="text-muted"> This page provides a chat interface for communication with other users. </p>              
            </CCol>
            <CCol md="12">
                <vue-advanced-chat
                    :current-user-id="$data.currentUserId"
                    :rooms="JSON.stringify($data.rooms)"
                    :messages="JSON.stringify($data.messages)"
                    :room-actions="JSON.stringify($data.roomActions)"
                />
            </CCol>
        </CRow>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { register } from 'vue-advanced-chat';

register()

const $data: any = reactive({
    currentUserId: '1234',
    rooms: [],
    messages: [],
    roomActions: [
        { name: 'inviteUser', title: 'Invite User' },
        { name: 'removeUser', title: 'Remove User' },
        { name: 'deleteRoom', title: 'Delete Room' }
    ]  
})
</script>
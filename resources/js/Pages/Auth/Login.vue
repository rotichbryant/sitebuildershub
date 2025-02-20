<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email:    String(),
    password: String(),
    remember: Boolean(),
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Sign In" />
        <CCol :md="8">
            <CCardGroup>
                <CCard class="p-4">
                    <CCardBody>
                    <CForm @submit.prevent="submit">
                        <h1>Login</h1>
                        <p class="text-body-secondary">Sign In to your account</p>
                        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                            {{ status }}
                        </div>
                        <CInputGroup class="mb-3">
                            <CInputGroupText>
                                <CIcon icon="cil-user" />
                            </CInputGroupText>
                            <CFormInput
                                placeholder="Email Address"
                                autocomplete="email"
                                v-model="form.email"
                            />
                        </CInputGroup>
                        <CInputGroup class="mb-4">
                            <CInputGroupText>
                                <CIcon icon="cil-lock-locked" />
                            </CInputGroupText>
                            <CFormInput
                                type="password"
                                placeholder="Password"
                                autocomplete="current-password"
                                v-model="form.password"
                            />
                        </CInputGroup>
                        <CRow>
                            <CCol :xs="6">
                                <CButton color="primary" class="px-4" type="submit" :disabled="form.processing"> Login </CButton>
                            </CCol>
                            <CCol :xs="6" class="text-right">
                                <CButton color="link" class="px-0">
                                Forgot password?
                                </CButton>
                            </CCol>
                        </CRow>
                    </CForm>
                    </CCardBody>
                </CCard>
                <CCard class="text-white bg-primary py-5" style="width: 44%">
                    <CCardBody class="text-center">
                    <div>
                        <h2>Sign up</h2>
                        <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore magna
                        aliqua.
                        </p>
                        <CButton color="light" variant="outline" class="mt-3">
                        Register Now!
                        </CButton>
                    </div>
                    </CCardBody>
                </CCard>
            </CCardGroup>
        </CCol>
    </GuestLayout>
</template>

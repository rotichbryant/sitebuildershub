<template>
    <GuestLayout>
        <Head title="Sign In" />
        <CCol :lg="5" :md="6" :sm="10" :xs="12">
            <CCardGroup>
                <CCard class="p-4">
                    <CCardBody>
                        <CForm @submit.prevent="submit">
                            <CCol :xs="12" class="text-center">
                                <h1>Login</h1>
                                <p class="text-body-secondary">Sign In to your account</p>
                            </CCol>
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
                                    :invalid="has()"
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
                                <CButton color="primary" class="px-4" type="submit" :disabled="form.processing"><CSpinner size="sm" v-if="form.processing"/> Login </CButton>
                                <CButton color="link" class="px-0">Forgot password?</CButton>
                            </CRow>
                        </CForm>
                    </CCardBody>
                </CCard>
            </CCardGroup>
        </CCol>
    </GuestLayout>
</template>
<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { has } from 'lodash';

defineProps<{
    errors: any;
    canResetPassword?: boolean;
    status?: string;
}>();

// const $data: any = 
/**
 * The login form data.
 *
 * @prop {String} email - The user's email address.
 * @prop {String} password - The user's password.
 * @prop {Boolean} remember - Whether to remember the user.
 */
const form = useForm({
    email:    String(),
    password: String(),
    remember: Boolean(),
});

/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
const submit = () => {
    form.post(route('dashboard.login'), {
        onError: (value) => {
            console.log(value)
        },
        /**
         * Resets the password field on success.
         */
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <LandingLayout>
        <Head title="Forbidden" />
        <div class="container-fluid pt-18 pb-15">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xs-12">

                </div>
            </div>
        </div>
    </LandingLayout>
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const $props: any = computed( () => usePage().props );

const subscription: any = computed( () => $props.value.auth.user.subscription );
</script>
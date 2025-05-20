<template>
    <LandingLayout>
        <Head title="Error" />
    </LandingLayout>    
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head, usePage } from '@inertiajs/vue3';
import { CChart } from '@coreui/vue-chartjs';
import { computed } from 'vue';

const stats: any = computed(() => usePage().props.stats);

</script>
<template>
    <LandingLayout>
        <Head title="Profile" />
        <div class="container-fluid pt-26 pb-15">
            <div class="row justify-content-center">
                    <div class="col-md-8 col-xs-12">
                        <div class="row">
                            <div class="col-md-3 col-xs-8">
                                <ul class="list-group mb-4">
                                    <li :class="`list-group-item ${$props.tab == 'personal' ? 'active' : '' }`">
                                        <a :href="route('landing.profile', { tab: 'personal' })" :class="`${$props.tab == 'personal' ? 'text-white' : '' }`">Personal Details</a>
                                    </li>
                                    <li :class="`list-group-item ${$props.tab == 'business' ? 'active' : '' }`">
                                        <a :href="route('landing.profile', { tab: 'business' })" :class="`${$props.tab == 'business' ? 'text-white' : '' }`">Business Details</a>
                                    </li>
                                </ul>                                
                            </div>
                            <div class="col-md-9 col-xs-12 ">
                                <PersonalDetailsTab v-if="$props.tab == 'personal'" />
                                <BusinessDetailsTab v-if="$props.tab == 'business'" />
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>
<style lang="css">
    .sidebar a{
        position: relative;
    }

    .sidebar a::after {
        content: "";
        position: absolute;
        top: 0;
        right: -100px; /* adjust this value to position the list group */
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        padding: 10px;
        display: none;
        width: 100px;
        height: 100px;
    }

    .sidebar a:hover::after {
        display: block;
    }

    .sidebar a::after .list-group {
        display: block;
    }

    .sidebar a::after .list-group-item {
        display: block;
        margin-bottom: 10px;
    }
    /* .list-group-item > .sidebar-item:hover::after {
        display: block;
    } */
</style>
<script lang="ts" setup>
import { BusinessDetailsTab, PersonalDetailsTab } from '@/Components/Landing';
import { LandingLayout } from '@/Layouts';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const $props = computed( () => usePage().props );
</script>
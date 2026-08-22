<template>
    <LandingLayout>
        <Head title="Profile" />
        <div class="container-fluid pt-18 pb-15">
            <div class="row justify-content-center">
                    <div class="col-md-8 col-xs-12">
                        <div class="row">
                            <div class="col-md-3 col-xs-8">
                                <ul class="list-group mb-4 border-0 shadow-sm">
                                    <li :class="`list-group-item ${$props.tab == 'personal' ? 'active' : '' }`">
                                        <a :href="route('landing.profile', { tab: 'personal' })" :class="`${$props.tab == 'personal' ? 'text-white' : '' }`"><i class="fa fa-user mr-2"></i>Personal Details</a>
                                    </li>
                                    <li :class="`list-group-item ${$props.tab == 'subscription' ? 'active' : '' }`">
                                        <a :href="route('landing.profile', { tab: 'subscription' })" :class="`${$props.tab == 'subscription' ? 'text-white' : '' }`"><i class="fa fa-check-circle mr-2"></i>Subscription</a>
                                    </li>   
                                    <li :class="`list-group-item ${$props.tab == 'invoices' ? 'active' : '' }`">
                                        <a :href="route('landing.profile', { tab: 'invoices' })" :class="`${$props.tab == 'invoices' ? 'text-white' : '' }`"><i class="fa fa-file mr-2"></i>Invoices</a>
                                    </li>                                    
                                    <li :class="`list-group-item ${$props.tab == 'projects' ? 'active' : '' }`">
                                        <a 
                                            :href="`${ subscription.features.for_professionals ? route('landing.profile', { tab: 'projects' }) : '#'}`" 
                                            :class="{ 'text-white': $props.tab == 'projects', 'text-muted': !subscription.features.for_professionals }" 
                                            :disabled="!subscription.features.for_professionals"
                                        >
                                            <i class="fa fa-list mr-2"></i>
                                            Project Detail
                                            <i class="fa fa-lock mr-2" v-if="!subscription.features.for_professionals"></i>
                                            <i class="fa fa-question-circle" v-if="!subscription.features.for_businesses"></i>
                                        </a>
                                    </li>
                                    <li :class="`list-group-item ${$props.tab == 'business' ? 'active' : '' }`">
                                        <a 
                                            :href="`${ subscription.features.for_businesses ? route('landing.profile', { tab: 'business' }) : '#'}`" 
                                            :class="{ 'text-white': $props.tab == 'projects', 'text-muted': !subscription.features.for_businesses }" 
                                            :disabled="!subscription.features.for_businesses"
                                        >
                                            <i class="fa fa-building mr-2"></i>
                                            Business Details
                                            <i class="fa fa-lock mr-2" v-if="!subscription.features.for_businesses"></i>
                                            <i class="fa fa-question-circle" v-if="!subscription.features.for_businesses"></i>
                                        </a>
                                    </li>                                    
                                    <li :class="`list-group-item ${$props.tab == 'business' ? 'active' : '' }`" v-if="subscription.features.for_businesses">
                                        <a :href="route('landing.profile', { tab: 'business' })" :class="`${$props.tab == 'business' ? 'text-white' : '' }`">Business Details</a>
                                    </li>
                                </ul>                                
                            </div>
                            <div class="col-md-9 col-xs-12 ">
                                <PersonalDetailsTab v-if="$props.tab == 'personal'" />
                                <InvoicesTab v-if="$props.tab == 'invoices'" />
                                <SubscriptionTab v-if="$props.tab == 'subscription'" />
                                <ProjectDetailsTab v-if="$props.tab == 'projects' && subscription.features.for_professionals" />
                                <BusinessDetailsTab v-if="$props.tab == 'business' && subscription.features.for_businesses" />
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
import { BusinessDetailsTab, InvoicesTab, SubscriptionTab, PersonalDetailsTab, ProjectDetailsTab } from '@/Components/Landing';
import { LandingLayout } from '@/Layouts';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const $props: any = computed( () => usePage().props );

const subscription: any = computed( () => $props.value.auth.user.activeSubscription );
</script>
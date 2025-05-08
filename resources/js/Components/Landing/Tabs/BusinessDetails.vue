<template>
    <div class="col-12">
        <h5>Business Details</h5>
        <!-- Tab navigation -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a :class="`nav-link ${$data.tab == 1 ? 'active' : '' }`" href="#details" @click="$data.tab = 1">Details</a>
            </li>
            <li class="nav-item" v-if="!isNull(business_profile)">
                <a :class="`nav-link ${$data.tab == 2 ? 'active' : '' }`" href="#delivery" @click="$data.tab = 2">Stores</a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content">
            <div :class="`tab-pane py-4 ${$data.tab == 1 ? 'active' : '' }`" id="tab1">
                <div class="card">
                    <div class="card-body">
                        <BusinessDetailsForm
                            :data="business_profile" 
                            :csrf_token="csrf_token"
                        />
                    </div>
                </div>
            </div>
            <div :class="`tab-pane py-4 ${$data.tab == 2 ? 'active' : '' }`" id="tab2" v-if="!isNull(business_profile)">
                <div class="card">
                    <div class="card-body">
                        <Stores 
                            :data="stores" 
                        />
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { BusinessDetailsForm, Stores } from '../Forms';
import { reactive } from 'vue';
import { isNull } from 'lodash';

const $data = reactive({
    tab: 1,
});

const business_profile = usePage().props.business_profile;
const csrf_token       = usePage().props.csrf_token;
const delivery_options = usePage().props.delivery_options;
const stores           = usePage().props.stores;

</script>
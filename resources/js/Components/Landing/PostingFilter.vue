<template>
    <form action="/" class="search-form search-2-adjustment ml-lg-0 ml-md-15">
        <div class="filter-search-form-2 bg-white rounded-sm shadow-7 pr-6 py-6 pl-6">
        <div class="filter-inputs">
            <div class="form-group position-relative w-lg-45 w-xl-40 w-xxl-45">
                <input class="form-control focus-reset pl-13" type="text" id="keyword" placeholder="Search by name">
                <span class="h-100 w-px-50 pos-abs-tl d-flex align-items-center justify-content-center font-size-6">
                <i class="icon icon-zoom-2 text-primary font-weight-bold"></i>
                </span>
            </div>
            <!-- .select-city starts -->
            <div class="form-group position-relative w-lg-55 w-xl-60 w-xxl-55">
                <select name="location" id="location" class="nice-select pl-13 h-100 arrow-3 font-size-4">
                    <option data-display="City, state, zip code or (Remote)" value="">Select Location</option>
                    <optgroup :label="key"  v-for="(county,key) in locations" :key="key">
                        <option :value="town" v-for="(town,index) in county" :key="index">{{ town  }}</option>
                    </optgroup>
                </select>
                <span class="h-100 w-px-50 pos-abs-tl d-flex align-items-center justify-content-center font-size-6">
                <i class="icon icon-pin-3 text-primary font-weight-bold"></i>
                </span>
            </div>
            <!-- ./select-city ends -->
        </div>
        <div class="button-block">
            <button class="btn btn-primary line-height-reset h-100 btn-submit w-100 text-uppercase">Search</button>
        </div>
        </div>
    </form> 
</template>

<script setup lang>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const locations = computed( () => usePage().props.locations );
</script>
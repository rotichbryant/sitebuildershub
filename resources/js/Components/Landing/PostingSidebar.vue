<template>
    <div>
        <!-- Sidebar Start -->
        <div class="widgets mb-11">
            <h4 class="font-size-6 font-weight-semibold mb-6">Categories</h4>
            <Multiselect 
                :group-select="true"
                group-values="sub_categories" 
                group-label="category"
                :options="categories"
                track-by="name" 
                label="name"
                v-model="filters.category"
            />
            <!-- <ul class="list-unstyled filter-check-list">
                <li class="mb-2">
                    <template v-for="(category,index) in categories">
                        <a href="#" class="toggle-item" @click="filters.category.push({ name: category.slug, sub_category: '' })">{{ category.name }}</a>
                        <template v-if="!isEmpty(filters.category) && filters.category.name == category.slug">
                            <ul class="list-unstyled filter-check-list">
                                <li class="mb-2">
                                    <template v-for="(sub_category,index) in category.sub_categories">
                                        <a href="#" class="toggle-item">{{ sub_category.name }}</a>
                                    </template>
                                </li>
                            </ul>
                        </template>
                    </template>
                </li>
            </ul> -->
        </div>
        <div class="widgets mb-11 ">
        <div class="d-flex align-items-center pr-15 pr-xs-0 pr-md-0 pr-xl-22">
            <h4 class="font-size-6 font-weight-semibold mb-6 w-75">Price Range</h4>
            <!-- Range Slider -->
            <div class="slider-price w-25 text-right mr-7">
                <p class="font-weight-bold">
                    <input class="text-primary font-weight-semibold font-size-4 focus-reset" type="text" id="amount" />
                </p>
            </div>
        </div>
        <div class="graph text-center mx-0 mt-5 position-relative chart-postion">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="range-slider">
            <div class="pm-range-slider"></div>
        </div>
        </div>
        <!-- Sidebar End -->        
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script lang="ts" setup>
import { computed, defineProps } from 'vue';
import { isEmpty } from 'lodash';
import Multiselect from 'vue-multiselect'
import { options } from 'dropzone-vue3';

const props: any = defineProps({ 
    categories: {
        default:  Array(),
        type:     Array,
        required: true
    },
    filters: {
        default:  Object(),
        type:     Object,
        required: true
    }
});

const $emit:      any = defineEmits(['update:filters']);

const categories: any = computed( 
    () => props.categories.map( 
        (category: any) => ({ 
            category:       category.name, 
            slug:           category.slug, 
            sub_categories: category.sub_categories.map( 
                (sub_category: any) => ({ 
                    ...sub_category,
                    category_slug: category.slug,
                }) 
            )
        })
    )
);
const filters:    any = computed({
    get: () => props.filters,
    set: () => $emit('update:filters', filters)
});
</script>
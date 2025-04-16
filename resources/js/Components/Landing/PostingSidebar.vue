<template>
    <div>
        <div class="widgets mb-4">
            <p v-if="!isEmpty(filters.categories)" class="badge badge-primary p-3">
                {{ filters.categories.map( (category: any) => category.name ).join(', ') }}
                <a href="#" class="text-white ml-3"><i class="fa fa-close"></i></a>
            </p>
            <p v-if="!isEmpty(filters.cities)" class="badge badge-info p-3">
                {{ filters.cities.map( (city: any) => city.name ).join(', ') }}
                <a href="#" class="text-white ml-3"><i class="fa fa-close"></i></a>
            </p>
            <p v-if="!isEmpty(filters.price_range)" class="badge badge-warning p-3">
                {{ filters.price_range.map( (price: any) => `KSH ${price}` ).join(' to ') }}
                <a href="#" class="text-white ml-3"><i class="fa fa-close"></i></a>
            </p>
        </div>
        <div class="widgets mb-4">
            <h4 class="font-size-6 font-weight-semibold ">Name</h4>
            <div class="form-group position-relative w-100 mb-0">
                <input class="form-control focus-reset" type="text" placeholder="Search by name" v-model="filters.name">
            </div>
        </div>
        <div class="widgets mb-4">
            <h4 class="font-size-6 font-weight-semibold">Location</h4>
            <Multiselect 
                :group-select="true"
                group-values="cities" 
                group-label="name"
                :options="locations"
                :multiple="true"
                track-by="name" 
                label="name"
                v-model="filters.cities"
            />
        </div>
        <!-- Sidebar Start -->
        <div class="widgets mb-4">
            <h4 class="font-size-6 font-weight-semibold">Categories</h4>
            <Multiselect 
                :group-select="true"
                group-values="sub_categories" 
                group-label="category"
                :options="categories"
                :multiple="true"
                track-by="name" 
                label="name"
                v-model="filters.categories"
            />
        </div>
        <div class="widgets mb-4">
            <div class="d-flex align-items-center pr-15 pr-xs-0 pr-md-0 pr-xl-22">
                <h4 class="font-size-6 font-weight-semibold mb-6 w-75">Price Range</h4>
                <!-- Range Slider -->
                <div class="slider-price w-25 text-right mr-7">
                    <p class="font-weight-bold">
                        <input 
                            class="text-primary font-weight-semibold font-size-4 focus-reset" 
                            type="text" 
                            id="amount" 
                            data-currency="KSH" 
                            data-min="1" 
                            data-max="100000" 
                            data-lower="2500" 
                            data-upper="40000" 
                        />
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
        <div class="col-12 px-0 py-3">
            <button class="btn btn-primary text-uppercase font-size-3 w-100" type="button" @click="$emit('filter')">
                Apply Filter
            </button>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
    .sub-level {
        display: none;
    }
</style>
<script lang="ts" setup>
import { computed, onMounted, defineProps } from 'vue';
import { isEmpty, keyBy, map } from 'lodash';
import Multiselect from 'vue-multiselect'
import { options } from 'dropzone-vue3';
import { usePage } from '@inertiajs/vue3';

const props: any     = defineProps({ 
    categories: {
        default:  Array(),
        type:     Array,
        required: true
    },
    locations: {
        default:  Object(),
        type:     Object,
        required: true
    },
    filters: {
        default:  Object(),
        type:     Object,
        required: true
    }
});

const locations: any = computed( 
    () => map(props.locations,
        (cities: any,key: string) => ({ 
            name: key, 
            cities: cities.map( 
                (city: string) => ({ name: city }) 
            ) 
        })
    )
);

const $emit:      any = defineEmits(['update:filters','filter']);

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

onMounted(
    () => {
        $(".pm-range-slider").slider({
            range: true,
            min: $("#amount").data('min'),
            max: $("#amount").data('max'),
            values: [
                $("#amount").data('lower'), 
                $("#amount").data('upper')
            ],

            slide: (_:any, ui:any) => {
                filters.value.price_range = ui.values;
                $("#amount").val(`${$("#amount").data('currency')} ${ui.values[0]} - ${$("#amount").data('currency' ) } ${ui.values[1]}`);
            },
            create: (_:any,ui:any) => {
                $("#amount").val(`${$("#amount").data('currency')} ${$("#amount").data('lower')} - ${$("#amount").data('currency')} ${$("#amount").data('upper')}`);
            }
        });
    }
)

</script>
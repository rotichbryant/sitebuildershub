<template>
    <LandingLayout>
        <Head title="Postings" />
        <!-- Main Content Start -->
        <div class="bg-default-1 pt-26 pt-lg-28 pb-13 pb-lg-25">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-xs-12">
                    <div class="row">
                        <div class="col-md-3 col-xs-8">
                            <PostingSidebar
                                :locations="$data.locations"
                                :categories="$data.categories"
                                :filters="$data.filters"
                                @filter="applyFilter"
                                @update-filters="$data.filters = $event"
                            />
                        </div>
                        <div class="col-md-9 col-xs-12 ">
                            <!-- form -->
                            <!-- <PostingFilter /> -->
                            <div class="pt-12 ml-lg-0 ml-md-15">
                                <div class="row">
                                    <Deferred data="postings">
                                        <template #fallback>
                                            <div>Loading...</div>
                                        </template>
                                        <template v-for="(posting,index) in $data.postings.data" :key="posting.id">
                                            <Posting 
                                                :data="posting" 
                                            />
                                        </template>
                                    </Deferred>
                                </div>
                                <div class="text-center pt-5 pt-lg-13">
                                    <a class="text-green font-weight-bold text-uppercase font-size-3 d-flex align-items-center justify-content-center" href="#">
                                        Load More
                                        <i class="fas fa-sort-down ml-3 mt-n2 font-size-4"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- form end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Main Content end -->
    </LandingLayout>
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head, router, usePage } from '@inertiajs/vue3';
import { Posting, PostingFilter, PostingSidebar } from '../../Components/Landing';
import { Deferred } from '@inertiajs/vue3'
import { computed, inject, onMounted, reactive, ref } from 'vue';
import { isEmpty, get, keys, set, forEach, intersection, intersectionBy, map } from 'lodash';

const $toast: any = inject('$toast'); 
const $data: any  = reactive({
    categories:   usePage().props.categories,
    locations:    usePage().props.locations,
    queryParams:  Object.fromEntries(new URLSearchParams(window.location.search).entries()),
    postings:     usePage().props.postings,
    filters:{
        categories:  ref([]),
        cities:      ref([]),
        price_range: String(),
        name:        ref([])
    },
});

const applyFilter = () => {
    let filters     = {}
    let filter_keys = keys($data.filters).filter( (value:any) => !isEmpty( get($data.filters,value) ));

    if( isEmpty(filter_keys) ){
        $toast.info('Please select at least one filter.');
        return;
    }

    filter_keys.forEach( (value) => {
        switch(value){
            case 'categories':
                set(filters, 'categories', decodeURIComponent(get($data.filters,value).map( (category:any) => category.name ).join(',')));
            break;
            case 'cities':
                set(filters, 'cities', decodeURIComponent(get($data.filters,value).map( (city:any) => city.name ).join(',')));
            break;
            case 'price_range':
                set(filters, 'price_range', decodeURIComponent(get($data.filters,value).join(',')));
            break;
            case 'name':
                set(filters, 'name', get($data.filters,value));
            break;
        }
    });
    
    router.get(
        route('landing.postings'), 
        filters,
        {

            onSuccess: (value) => {
                console.log(value);
                // $data.postings = cloneDeep(postings);
            }
        }
    );
}

onMounted(
    () => {
        forEach(
            $data.queryParams,
            (value,key) => {
                switch(key){
                    case 'categories':
                        $data.filters.categories = intersectionBy(
                            $data.categories.map( (category: any) => category.sub_categories).flat(),
                            value.split(',').map( (category:any) => ({ name: category }) ),
                            'name'
                        );
                    break;
                    case 'cities':
                        $data.filters.cities = intersectionBy(
                            map($data.locations,(cities,key) => cities ).flat().map( city => ({ name: city }) ),
                            value.split(',').map( (city:any) => ({ name: city }) ),
                            'name'
                        );
                    break;
                    case 'price_range':
                        $data.filters.price_range = value.split(',');
                    break;
                    case 'name':
                        $data.filters.name = value;
                    break;
                }
            }
        )
        console.log($data.queryParams);
        // const router = 
    }
)

</script>
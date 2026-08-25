<template>
    <LandingLayout>
        <Head title="Postings" />
        <template #breadcrumb>
            <ul class="crumb">
                <li><h4><a :href="route('landing.home')">Home</a></h4></li>
                <li><h4><a :href="route('landing.postings')">Postings</a></h4></li>
            </ul>
        </template>          
        <!-- Main Content Start -->
        <div class="bg-default-1 pt-10">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-xs-12">
                    <div class="row">
                        <div class="col-md-3 col-xs-8">
                            <div class="bg-white shadow-9 rounded-4 mb-6">
                                <PostingSidebar
                                    :locations="$data.locations"
                                    :categories="$data.categories"
                                    :filters="$data.filters"
                                    @filter="applyFilter"
                                    @update-filters="$data.filters = $event"
                                />
                            </div>
                            <div class="bg-white shadow-9 mb-6 p-5" v-if="!isEmpty(advert_images)">
                                <Swiper 
                                    slidesPerView="auto" 
                                    :spaceBetween="30" 
                                    :modules="$data.modules" 
                                    :loop="true" 
                                    :pagination="{clickable: true}"
                                    :centeredSlides="true"
                                    :autoplay="{delay: 2500,disableOnInteraction: false}"                
                                >
                                    <SwiperSlide v-for="(image,index) in advert_images" :key="index">
                                        <img :src="image.url" :height="image.height" style="display:">
                                    </SwiperSlide>
                                </Swiper>    
                            </div>                            
                        </div>
                        <div class="col-md-9 col-xs-12 ">
                            <!-- form -->
                            <!-- <PostingFilter /> -->
                            <div class="ml-lg-0 ml-md-15">
                                <div class="row">
                                    <template v-for="(posting,index) in $data.postings.data" :key="posting.id" >
                                        <Posting 
                                            :data="posting" 
                                        />                                        
                                    </template>
                                    <template v-if="isEmpty($data.postings.data)" >
                                        <div class="col-12 d-flex align-items-center justify-content-center" style="height: 50vh;" >
                                            <h6 class="text-primary">
                                                <i class="fa fa-exclamation-circle mr-2"></i>
                                                <span>Nothing Found Here</span>
                                            </h6>
                                        </div>                                              
                                    </template>
                                    <template v-if="!isEmpty($data.postings.data)" >
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <li class="page-item" v-bind:class="{ 'disabled': page.url == null, 'active': page.active }" v-for="(page,key) in $data.postings.links" :key="key">
                                                        <a 
                                                            class="page-link" 
                                                            :href="page.url"                                                                 
                                                            v-html="page.label"
                                                        ></a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>                                            
                                    </template>                                                                     
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
import { Head, router, usePage, WhenVisible } from '@inertiajs/vue3';
import { Posting, PostingFilter, PostingSidebar } from '../../Components/Landing';
import { computed, inject, onMounted, reactive, ref } from 'vue';
import { isEmpty, get, keys, set, forEach, intersection, intersectionBy, map, delay, times } from 'lodash';
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

// import required modules
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

const $toast: any = inject('$toast'); 
const $data: any  = reactive({
    categories:   usePage().props.categories,
    locations:    usePage().props.locations,
    queryParams:  Object.fromEntries(new URLSearchParams(window.location.search).entries()),
    postings:     usePage().props.postings,
    filters:{
        categories:  ref([]),
        sub_categories:  ref([]),
        cities:      ref([]),
        price_range: String(),
        name:        ref([])
    },
    modules: [Autoplay, Pagination, Navigation],
});

const $props: any = defineProps({
    placements: Array,
});

const advert_images = computed( 
    () => $props.placements
                .map(        (item:any) => ({ ...item, promotions: item.promotions.map( (promotion:any) => ({ ...promotion, height: item.custom.height, width: item.custom.width  })) }) )
                .map(        (item:any) => item.promotions )
                .flat().map( (item:any) => ({ url: item.image, height: item.height, width: item.width }) )
);


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
            case 'sub_categories':
                set(filters, 'sub_categories', decodeURIComponent(get($data.filters,value).map( (category:any) => category.name ).join(',')));
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
    }
)

</script>
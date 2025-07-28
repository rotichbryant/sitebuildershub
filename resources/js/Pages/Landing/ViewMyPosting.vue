<template>
    <LandingLayout>
        <Head title="View Posting" />
        <!-- Main Content Start -->
        <div class="bg-default-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-10 mx-auto">
                        <!-- back Button -->
                        <div class="row justify-content-center">
                            <div class="col-12 dark-mode-texts">
                                <div class="mb-9">
                                    <a class="d-flex align-items-center ml-4" :href="route('landing.mypostings')"> 
                                        <i class="fa fa-chevron-left bg-white circle-40 mr-5 text-black font-weight-bold shadow-8"></i>
                                        <span class="text-uppercase font-size-3 font-weight-bold text-gray">Back</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- back Button End -->
                        <div class="row">
                            <!-- Middle Content -->
                            <div class="col-12 col-md-9">
                                <div class="bg-white rounded-4 shadow-9">
                                    <div class="pr-xl-0 pr-xxl-14 p-5 px-xs-12 pt-7 pb-5">
                                        <h4 class="font-size-6 text-black-2 font-weight-semibold">{{ posting.title }}</h4>
                                        <ul class="list-unstyled d-flex flex-wrap">
                                            <li><a :href="route('landing.postings',{category: posting.category.name})">{{ posting.category.name }}</a></li>
                                            <li><i class="fa fa-chevron-right mx-2 fa-sm"></i></li>
                                            <li><a :href="route('landing.postings',{sub_category: posting.sub_category.name})">{{ posting.sub_category.name }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="pr-xl-0 pr-xxl-14 p-5 px-xs-12 pt-7 pb-5">
                                        <Carousel  
                                            :itemsToShow="1" 
                                            :wrap-around="false" 
                                            v-model="$data.slider.current"
                                        >
                                            <Slide v-for="(image,index) in posting.images" :key="index">
                                                <div class="p-0">
                                                    <InnerImageZoom :src="image" :zoomScale="2" /> 
                                                </div>                                    
                                            </Slide>
                                        </Carousel>                                    
                                    </div>
                                    <!-- Excerpt Start -->
                                    <div class="pr-xl-0 pr-xxl-14 p-5 px-xs-12 pt-7 pb-5">
                                        <h4 class="font-size-6 mb-7 mt-5 text-black-2 font-weight-semibold">Description</h4>
                                        <p class="font-size-4 mb-8">{{ posting.description }}</p>
                                    </div>
                                    <!-- Excerpt End -->
                                </div>
                            </div>
                            <!-- Middle Content -->
                            <!-- Right Sidebar Start -->
                            <div class="col-12 col-md-3 px-0">
                                <!-- Top Start -->
                                <div class="bg-white shadow-9 rounded-4 mb-6">
                                    <div class="px-5 py-4 border-bottom border-mercury">
                                        <h4>KSH {{ posting.price }}</h4>
                                        <p>
                                            <span class="badge badge-primary" v-if="posting.negotiate == 'yes'">Negotiable</span>
                                            <span class="badge badge-primary" v-if="posting.negotiate == 'no'">Fixed</span>
                                        </p>
                                        <button class="btn btn-outline-primary w-100">Request Call Back</button>
                                    </div>
                                    <!-- Top End -->
                                </div>
                                <!-- Top Start -->
                                <div class="bg-white shadow-9 rounded-4 mb-6">
                                    <div class="px-5 py-9 text-center border-bottom border-mercury">
                                        <div class="mb-6">
                                            <i class="fa fa-circle-user fa-xl circle-40 font-size-12 text-center font-weight-bold shadow-8 mx-auto"></i>
                                        </div>
                                        <h4 class="mb-0"><a class="text-black-2 font-size-6 font-weight-semibold" href="#">{{ posting.user.name }}</a></h4>
                                        <h5 class="font-size-4 font-weight-semibold mb-0 text-black-2 text-break">{{ posting.town }}, {{ posting.county }}</h5>
                                        <h5 class="font-size-4 font-weight-semibold mb-0" v-if="!isEmpty(posting.user.phone_number)"><a class="text-black-2 text-break" :href="`tel:${posting.user.phone_number}`">{{ posting.user.phone_number }}</a></h5>
                                    </div>
                                    <!-- Top End -->
                                </div>
                                <!-- Top Start -->
                                <div class="bg-white shadow-9 rounded-4 mb-6">
                                    <div class="px-5 py-4 border-bottom border-mercury">
                                        <h4>Comments</h4>
                                        <div class="text-center col-12">
                                            <span class="badge badge-info p-4"><i class="fa fa-exclamation-circle fa-lg mr-2"></i>Nothing Found Here</span>
                                        </div>                            
                                    </div>                                    
                                    <!-- Top End -->
                                </div> 
                                <div class="bg-white shadow-9 rounded-4 mb-6 p-3" v-if="posting.images.length > 1">  
                                    <h4>Images</h4>
                                    <Carousel
                                        id="thumbnails"
                                        :itemsToShow="2"
                                        :wrap-around="true"
                                        ref="carousel"
                                        v-model="$data.slider.current"
                                    >
                                        <Slide v-for="(image,index) in posting.images" :key="index">
                                            <img :src="image" alt="" width="70%">
                                        </Slide>
                                        <template #addons>
                                            <navigation />
                                            <pagination />
                                        </template>
                                    </Carousel>                                     
                                    <!-- Top End -->
                                </div>                                                                              
                            </div>
                            <!-- Right Sidebar End -->
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
import { Head, usePage } from '@inertiajs/vue3';
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import { isEmpty } from 'lodash';
import InnerImageZoom from 'vue-inner-image-zoom';
// import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import { reactive } from 'vue';

const posting: any = usePage().props.posting;

const $data: any   = reactive({
    slider: {
        current: 0,
    }
});
</script>
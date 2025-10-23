<template>
    <LandingLayout>
        <Head title="View Posting" />
        <template #breadcrumb>
            <ul class="crumb">
                <li><h4>Home</h4></li>
                <li><h4><a :href="route('landing.mypostings')">My Postings</a></h4></li>
                <li><h4><a :href="route('landing.mypostings.show',{ posting: posting.id })">{{ posting.title }}</a></h4></li>
            </ul>
        </template>
        <!-- Main Content Start -->
        <div class="bg-default-2 py-10">
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
                            <div class="col-12 col-md-8">
                                <div class="bg-white rounded-4 shadow-9">
                                    <Carousel  
                                        :itemsToShow="1" 
                                        :wrap-around="false" 
                                        v-model="$data.slider.current"
                                    >
                                        <Slide v-for="(image,index) in posting.images" :key="index">
                                            <InnerImageZoom :src="image" :zoomScale="4" />                                
                                        </Slide>
                                    </Carousel>                                                                      
                                    <div class="col-12 p-9">
                                        <h3 class="font-size-8 text-black-2 font-weight-semibold">{{ posting.title }}</h3>
                                        <ul class="list-unstyled d-flex flex-wrap">
                                            <li v-for="(value,index) in posting.categories">
                                                <a class="badge badge-primary p-4 mr-2" :href="route('landing.postings',{category: value.sub_category.name})">{{ value.sub_category.name }}</a>
                                            </li>
                                        </ul>
                                        <h4 class="font-size-6 mt-5 text-black-2 font-weight-semibold">Description</h4>
                                        <p class="font-size-4 mb-8">{{ posting.description }}</p>                                          
                                    </div>
                                </div>
                            </div>
                            <!-- Middle Content -->
                            <!-- Right Sidebar Start -->
                            <div class="col-12 col-md-4 px-0">
                                <!-- Top Start -->
                                <div class="bg-white shadow-9 rounded-4 mb-6 p-8">
                                    <h5>Quotation</h5>
                                    <iframe :src="posting.quotation" style="height: 50vh; width: 100%;"></iframe>
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
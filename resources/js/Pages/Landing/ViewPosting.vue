<template>
    <LandingLayout>
        <Head title="View Posting" />
        <template #breadcrumb>
            <ul class="crumb">
                <li><h4>Home</h4></li>
                <li><h4><a :href="route('landing.postings')">Postings</a></h4></li>
                <li><h4><a :href="route('landing.mypostings.show',{ posting: posting.id })">{{ posting.title }}</a></h4></li>
            </ul>
        </template>        
        <!-- Main Content Start -->
        <div class="bg-default-2 py-8">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-xs-12">                
                        <!-- back Button -->
                        <div class="row justify-content-center">
                            <div class="col-12 dark-mode-texts">
                                <div class="mb-9">
                                    <a class="d-flex align-items-center ml-4" :href="route('landing.postings')"> 
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
                                <div class="bg-white rounded-4 shadow-9 p-0">
                                    <Carousel  
                                        :itemsToShow="1" 
                                        :wrap-around="false" 
                                        v-model="$data.slider.current"
                                    >
                                        <Slide v-for="(image,index) in posting.images" :key="index">
                                            <InnerImageZoom :src="image" :zoomScale="4" />                                
                                        </Slide>
                                    </Carousel>     
                                    <div class="col-12 my-6" v-if="posting.images.length > 1">
                                        <Carousel
                                            id="thumbnails"
                                            :itemsToShow="3"
                                            :wrap-around="true"
                                            ref="carousel"
                                            v-model="$data.slider.current"
                                        >
                                            <Slide v-for="(image,index) in posting.images" :key="index">
                                                <img :src="image" alt="" width="100%" >
                                            </Slide>
                                            <template #addons>
                                                <navigation />
                                                <pagination />
                                            </template>
                                        </Carousel>    
                                    </div>                                                                                                        
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
                            <div class="col-12 col-md-3 px-0">
                                <!-- Top Start -->
                                <button class="btn btn-primary w-100 btn-lg mb-4" @click="getQuote" :disabled="$data.loaders.fetch">
                                    <i class="fa fa-spinner fa-spin" v-if="$data.loaders.fetch"></i>
                                    Get Quotation
                                </button>  
                                <!-- Top Start -->
                                <div class="bg-white shadow-9 rounded-4 mb-6">
                                    <div class="p-5 text-center border-bottom border-mercury">
                                        <div class="mb-6">
                                            <i class="fa fa-circle-user fa-xl circle-40 font-size-12 text-center font-weight-bold shadow-8 mx-auto"></i>
                                        </div>
                                        <h4 class="mb-0"><a class="text-black-2 font-size-6 font-weight-semibold" href="#">{{ posting.user.name }}</a></h4>
                                        <h5 class="font-size-4 font-weight-semibold mb-0 text-black-2 text-break">{{ posting.town }}, {{ posting.county }}</h5>
                                        <h5 class="font-size-4 font-weight-semibold mb-3" v-if="!isEmpty(posting.user.phone_number)"><a class="text-black-2 text-break" :href="`tel:${posting.user.phone_number}`">{{ posting.user.phone_number }}</a></h5>
                                        <a :href="`https://wa.me/${posting.user.phone_number}`" v-if="!isEmpty(posting.user.phone_number)" target="_blank" class="btn btn-outline-primary w-100">Chat on Whatsapp</a>                                
                                    </div>
                                    <!-- Top End -->
                                </div>
                                <div class="bg-white shadow-9 rounded-4 p-6" >
                                    <h4>Feedback</h4>                       
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
import { inject, reactive } from 'vue';
import moment from 'moment';

const $toast: any = inject('$toast');
const posting: any = usePage().props.posting;
const $data: any   = reactive({
    slider: {
        current: 0,
    },
    loaders: {
        fetch: false
    }
});

const getQuote = async () => {
    try{ 
        $data.loaders.fetch = true;

        const response = await fetch(posting.quotation);
        const blob     = await response.blob(); // binary form of file

        // Create a URL for the blob
        const url = window.URL.createObjectURL(blob);
        
        // Create a temporary link
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `${moment().unix()} - Quotation.pdf`); // file name
        document.body.appendChild(link);
        link.click();

        // Cleanup
        link.remove();
        window.URL.revokeObjectURL(url);

        // Toast show message
        $toast.success('Quotaion has been created');   

        $data.loaders.fetch = false;

    } catch(error){

        $toast.error('Error in fetching quotation. Please try again later.');   
    
        $data.loaders.fetch = false;
    
    }

}
</script>
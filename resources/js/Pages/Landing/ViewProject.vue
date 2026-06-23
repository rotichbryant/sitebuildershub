<template>
    <LandingLayout>
        <Head title="View Posting" />
        <template #breadcrumb>
            <ul class="crumb">
                <li><h4>Home</h4></li>
                <li><h4><a :href="route('landing.projects')">Projects</a></h4></li>
                <li><h4>{{ project.title }}</h4></li>
            </ul>
        </template>        
        <!-- Main Content Start -->
        <div class="bg-default-2 py-8">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 ">                
                        <!-- back Button End -->
                        <div class="row  justify-content-center">
                            <!-- Middle Content -->
                            <div class="col-12 col-md-9">
                                <div class="mb-9">
                                    <a class="d-flex align-items-center ml-4" :href="route('landing.projects')"> 
                                        <i class="fa fa-chevron-left bg-white circle-40 mr-5 text-black font-weight-bold shadow-8"></i>
                                        <span class="text-uppercase font-size-3 font-weight-bold text-gray">Back</span>
                                    </a>
                                </div>                                
                                <div class="bg-white rounded-4 shadow-9 p-0">
                                    <Carousel  
                                        :itemsToShow="1" 
                                        :wrap-around="false" 
                                        v-model="$data.slider.current"
                                    >
                                        <Slide v-for="(image,index) in project.files" :key="index">
                                            <InnerImageZoom :src="image" :zoomScale="4" />                                
                                        </Slide>
                                    </Carousel>     
                                    <div class="col-12 my-6" v-if="project.files.length > 1">
                                        <Carousel
                                            id="thumbnails"
                                            :itemsToShow="3"
                                            :wrap-around="true"
                                            ref="carousel"
                                            v-model="$data.slider.current"
                                        >
                                            <Slide v-for="(image,index) in project.files" :key="index">
                                                <img :src="image" alt="" width="100%" >
                                            </Slide>
                                            <template #addons>
                                                <navigation />
                                                <pagination />
                                            </template>
                                        </Carousel>    
                                    </div>                                                                                                        
                                    <div class="col-12 p-9">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="font-size-8 text-black-2 font-weight-semibold">{{ project.title }}</h3>
                                                <p class="text-primary"><i class="fa fa-user mr-2"></i> {{ project.user.name }}</p>
                                                <p class="text-primary"><i class="fa fa-phone mr-2"></i> {{ project.user.phone_number }}</p>
                                            </div>
                                            <div class="col-12">
                                                <ul class="list-unstyled d-flex flex-wrap">
                                                    <li v-for="(value,index) in project.categories">
                                                        <a class="badge badge-primary p-4 mr-2" :href="route('landing.postings',{category: value.sub_category.name})">{{ value.sub_category.name }}</a>
                                                    </li>
                                                </ul>
                                            </div>  
                                            <div class="col-12">
                                                <div v-html="project.content"></div>
                                            </div>                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Middle Content -->
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
import InnerImageZoom from 'vue-inner-image-zoom';
// import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import { inject, reactive } from 'vue';
const $toast: any = inject('$toast');
const project: any = usePage().props.project;
const $data: any   = reactive({
    slider: {
        current: 0,
    },
    loaders: {
        fetch: false
    }
});
const props: any = defineProps({
    auth: {
        type: Object
    }
})

console.log(usePage().props)
</script>
<template>
    <LandingLayout>
        <Head title="Home" />

        <div class="col-12 px-0 position-relative">
            <Swiper 
                slidesPerView="auto" 
                :spaceBetween="30" 
                :modules="$data.modules" 
                :loop="true" 
                :pagination="{clickable: true}"
                :centeredSlides="true"
                :autoplay="{delay: 2500,disableOnInteraction: false}"  
                style="z-index: 0;"           
            >
                <SwiperSlide v-for="(image,index) in banner_images" :key="index">
                    <img :src="image.url" :height="image.height" width="100%" >
                </SwiperSlide>
            </Swiper>             
            <!-- Hero Area -->  
        </div>

        <div class="col-12 positive-relative px-0">
            <div class="container">
                <!-- Hero Form -->
                <div class="col-12 translateY-50 mx-auto" >
                    <form action="/" class="search-form">
                        <div class="filter-search-form-2 bg-white rounded-sm shadow-7 pr-8 py-7 pl-6">
                            <div class="filter-inputs">
                                <div class="form-group position-relative">
                                    <input class="form-control focus-reset pl-13" type="text" id="keyword" placeholder="Type Job title, keywords">
                                    <span class="h-100 w-px-50 pos-abs-tl d-flex align-items-center justify-content-center font-size-6"><i class="icon icon-zoom-2 text-primary font-weight-bold"></i></span>
                                </div>
                                <!-- .select-city starts -->
                                <div class="form-group position-relative">
                                    <select name="country" id="country" class="nice-select pl-13 h-100 arrow-3 font-size-4">
                                        <option data-display="City, state, zip code or (Remote)">City</option>
                                        <option value="">United States of America</option>
                                        <option value="">United Arab Emirates</option>
                                        <option value="">Bangladesh</option>
                                        <option value="">Pakistan</option>
                                    </select>
                                    <span class="h-100 w-px-50 pos-abs-tl d-flex align-items-center justify-content-center font-size-6"><i class="icon icon-pin-3 text-primary font-weight-bold"></i></span>
                                </div>
                                <!-- ./select-city ends -->
                            </div>
                            <div class="button-block">
                                <button class="btn btn-primary line-height-reset h-100 btn-submit w-100 text-uppercase">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End Hero Form -->       
            </div>   
        </div>
        
        <div class="col-12 px-0 pt-25" >
            <div class="container">
                <!-- Section Top -->
                <div class="row align-items-center justify-content-center">
                    <!-- Section Title -->
                    <div class="col-12 col-xl-6 col-lg-7 col-md-9">
                        <div class="text-center mb-12 mb-lg-17">
                            <h2 class="font-size-10 font-weight-bold mb-8">Explore by category</h2>
                        </div>
                    </div>
                </div>
                <!-- End Section Top -->
                <div class="row justify-content-center">
                    <!-- Single Category -->
                    <div class="col-12 col-xl-3 col-lg-4 col-sm-6 col-xs-8" v-for="(category,key) in $props.categories" :key="key">
                        <a href="#" class="bg-white border border-color-2 rounded-4 pl-5 pt-10 pb-3 px-2 hover-shadow-2 mb-9 d-block w-100 text-center">
                            <!-- Category Content -->
                            <div class="col-12">
                                <h5 class="font-size-5 font-weight-semibold text-black-2 line-height-1">{{ category.name }}</h5>
                                <p class="font-size-4 font-weight-normal text-gray"><span>{{ category.postings_count }}</span> Adverts</p>
                            </div>
                        </a>
                    </div>
                    <!-- End Single Category -->
                </div>
            </div>
        </div>

        <!-- Hero Area -->

        <!-- featuredJobOne Area -->
        <section class="bg-athens pt-12 pt-lg-24 pb-7 pb-lg-25">
            <div class="container">
                <!-- Section Title -->
                <div class="row justify-content-center mb-lg-16 mb-11">
                    <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-10 text-center">
                        <h2 class="mb-6 mb-lg-7 text-black-2 font-size-10">Featured Adverts</h2>
                        <p class="px-xs-3 px-md-12 px-lg-8 px-xl-8 px-xxl-6 font-size-5 mb-0">
                            Discover our top featured adverts showcasing a wide range of construction products.
                        </p>
                    </div>
                </div>
                <!-- Section Title End -->
                <div class="row justify-content-center">
                    <div class="col-xxl-9 col-xl-9 col-lg-10 mb-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true" v-for="(advert,index) in $props.postings">
                        <!-- Single Featured Job -->
                        <div class="pt-9 px-xl-9 px-lg-7 px-7 pb-7 light-mode-texts bg-white rounded hover-shadow-3 ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="media align-items-center">
                                        <div class="square-72 d-block mr-8" :key="`slider_${index}`">
                                            <Carousel
                                                id="thumbnails"
                                                :itemsToShow="1"
                                                :wrap-around="false"
                                                :autoPlay="true"
                                                ref="carousel"
                                                v-model="$data.slider.current"
                                            >
                                                <Slide v-for="(image,index) in advert.images" :key="index">
                                                    <img :src="image" alt="" width="150px">
                                                </Slide>
                                            </Carousel>                                             
                                            <!-- <img src="../../../image/l2/png/featured-job-logo-1.png" alt=""> -->
                                        </div>
                                        <div>
                                            <h3 class="mb-0"><a class="font-size-6 heading-default-color" href="#">{{advert.title}}</a></h3>
                                            <a href="#" class="font-size-3 text-default-color line-height-2">{{ advert.user.name }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right pt-7 pt-md-5">
                                    <div class="media justify-content-md-end">
                                        <p class="font-weight-bold font-size-7 text-hit-gray mb-0">
                                            <span class="text-black-2 text-success mr-2"><i class="fa fa-money-bill"></i></span>
                                            <span class="text-black-2">{{ advert.price }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-8">
                                <div class="col-md-7">
                                <ul class="d-flex list-unstyled mr-n3 flex-wrap">
                                    <li>
                                        <a class="bg-regent-opacity-15 min-width-px-96 mr-3 text-center rounded-3 px-6 py-1 font-size-3 text-black-2 mt-2" href="#">Visual Design</a>
                                    </li>
                                    <li>
                                        <a class="bg-regent-opacity-15 min-width-px-96 mr-3 text-center rounded-3 px-6 py-1 font-size-3 text-black-2 mt-2" href="#">Wireframing</a>
                                    </li>
                                    <li>
                                        <a class="bg-regent-opacity-15 min-width-px-96 mr-3 text-center rounded-3 px-6 py-1 font-size-3 text-black-2 mt-2" href="#">Scrum</a>
                                    </li>
                                </ul>
                                </div>
                                <div class="col-md-5">
                                <ul class="d-flex list-unstyled mr-n3 flex-wrap mr-n8 justify-content-md-end">
                                    <li class="mt-2 mr-8 font-size-small text-black-2 d-flex">
                                        <span class="mr-4" style="margin-top: -2px"><img src="../../../image/svg/icon-loaction-pin-black.svg" alt=""></span>
                                        <span class="font-weight-semibold">{{ }}</span>
                                    </li>
                                    <li class="mt-2 mr-8 font-size-small text-black-2 d-flex">
                                        <span class="mr-4" style="margin-top: -2px"><img src="../../../image/svg/icon-clock.svg" alt=""></span>
                                        <span class="font-weight-semibold">{{ advert.created_at }}</span>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Featured Job -->
                    </div>
                </div>
            </div>
        </section>
        <!-- featuredJobOne Area -->
    </LandingLayout>
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head } from '@inertiajs/vue3';
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide } from 'vue3-carousel';
import { computed, reactive } from 'vue';
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

// import required modules
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
const $props: any = defineProps({
    categories: Array,
    postings: Array,
    placements: Array,
});

const $data: any   = reactive({
    slider: {
        current: 0,
    },
    modules: [Autoplay, Pagination, Navigation],
});

const banner_images = computed( 
    () => $props.placements
                .filter(     (item:any) => item.section == 'top-banner' )
                .map(        (item:any) => ({ ...item, promotions: item.promotions.map( (promotion:any) => ({ ...promotion, height: item.custom.height, width: item.custom.width  })) }) )
                .map(        (item:any) => item.promotions )
                .flat().map( (item:any) => ({ url: item.image, height: item.height, width: item.width }) )
);

const leader_images = computed( 
    () => $props.placements
                .filter(     (item:any) => item.section == 'leader-banner' )
                .map(        (item:any) => ({ ...item, promotions: item.promotions.map( (promotion:any) => ({ ...promotion, height: item.custom.height, width: item.custom.width })) }) )
                .map(        (item:any) => item.promotions )
                .flat().map( (item:any) => ({ url: item.image, height: item.height, width: item.width }) )                
);
</script>
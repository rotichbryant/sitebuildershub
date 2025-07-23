<template>
    <LandingLayout>
        <Head title="Home" />
        <!-- Hero Area -->
        <div class="position-relative bg-squeeze pt-26 dark-mode-texts">
        <div class="pos-abs-tr h-100">
            <img src="../../../image/patterns/globe-pattern.png" alt="" class="h-100">
        </div>
        <div class="container position-static">
            <div class="row position-relative align-items-center position-static">
            <div class="col-xxl-7 col-xl-8 col-lg-9 pt-lg-23 pb-lg-33 pb-md-28 pb-xs-26 pb-29 pt-md-20" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="row">
                <div class="col-xxl-8 col-xl-7 col-md-8 col-sm-10">
                    <h1 class="font-size-11 mb-9 text-black-2">Find what you are looking for.</h1>
                    <p class="font-size-5">Our list of adverts showcase a wide range of construction products.</p>
                </div>
                </div>
            </div>
            <!-- Hero Form -->
            <div class="col-lg-11 col-12 translateY-50 pos-abs-bl" style="z-index: 1;">
                <form action="/" class="search-form" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
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
        </div>
        <!-- Hero Area -->
        <!-- category Area -->
        <div class="pb-13 pb-lg-25 bg-gradient-2">
            <div class="">
                <div class="container">
                    <hr class="pt-13 pt-lg-20">
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
                    <div class="row justify-content-center" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
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
        </div>
        <!-- category Area -->
        <!-- ContentOne Area -->
        <section class="pt-13 pt-lg-30 pb-13 pb-lg-30">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-10 col-xs-11 mb-9 mb-lg-0" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                        <!-- content-1 left-content start -->
                        <div class="position-relative pr-lg-20 pr-xs-15 pr-9 ">
                        <!-- content img start -->
                        <img src="../../../image/l2/png/content-2-img1.png" alt="" class="w-100">
                        <!-- content img end -->
                        <!-- abs-content start -->
                        <div class="abs-content pos-abs-br bg-white shadow-2 pl-7 pt-8 pb-1 pr-11 max-width-px-311 rounded mb-15 mb-xs-18 mb-lg-15 mb-xl-18">
                            <!-- media start -->
                            <div class="media mb-5">
                            <!-- check-mark start -->
                            <span class="check-mark bg-yellow-2 circle-41">
                                                <i class="fas fa-check text-white  font-size-6"></i>
                                            </span>
                            <!-- check-mark end -->
                            <!-- media body start -->
                            <div class="media-body pl-5">
                                <h6 class="mb-0 font-size-3 text-green text-uppercase">Job alert!</h6>
                                <p class="mb-0 font-size-4 text-black-2">104 new jobs are available in this week!</p>
                            </div>
                            <!-- media body start -->
                            </div>
                            <!-- media end -->
                        </div>
                        <!-- abs-content end -->
                        </div>
                        <!-- content-1 left-content end -->
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-8 col-xs-10" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                        <!-- content-1 start -->
                        <div class="content-1 pl-xl-5 pl-xxl-11 pr-xxl-10">
                        <!-- content-1 section-title start -->
                        <h2 class="font-size-9 mb-md-15 mb-13">Help you to get the <br class="d-none d-sm-block">
                                        best job that fits you</h2>
                        <!-- content-1 section-title end -->
                        <!-- media start -->
                        <div class="media mb-11">
                            <!-- media icon start -->
                            <div class="media-icon px-6 py-5 bg-green-opacity-2 rounded-5">
                            <i class="icon icon-layout-11 text-green"></i>
                            </div>
                            <!-- media icon start -->
                            <!-- media body start -->
                            <div class="media-body pl-7">
                            <h5 class="mb-5 h5">#1 Jobs site in UK</h5>
                            <p class="mb-0 font-size-4 text-default-color">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative</p>
                            </div>
                            <!-- media body start -->
                        </div>
                        <!-- media end -->
                        <!-- media start -->
                        <div class="media mb-11">
                            <!-- media icon start -->
                            <div class="media-icon px-6 py-5 bg-yellow-2-opacity-2 rounded-5">
                            <i class="fa fa-search text-yellow-2"></i>
                            </div>
                            <!-- media icon start -->
                            <!-- media body start -->
                            <div class="media-body pl-7">
                            <h5 class="mb-5 h5">Seamless searching</h5>
                            <p class="mb-0 font-size-4 text-default-color">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test.</p>
                            </div>
                            <!-- media body start -->
                        </div>
                        <!-- media end -->
                        <!-- media start -->
                        <div class="media">
                            <!-- media icon start -->
                            <div class="media-icon px-6 py-5 bg-red-opacity-2 rounded-5">
                            <i class="fa fa-industry text-red"></i>
                            </div>
                            <!-- media icon start -->
                            <!-- media body start -->
                            <div class="media-body pl-7">
                            <h5 class="mb-5 h5">Hired in top companies</h5>
                            <p class="mb-0 font-size-4 text-default-color">Podcasting operational change management inside of workflows to establish.</p>
                            </div>
                            <!-- media body start -->
                        </div>
                        <!-- media end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ContentOne Area -->
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
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import { reactive } from 'vue';

const $props: any = defineProps({
    categories: Array,
    postings: Array
});

const $data: any   = reactive({
    slider: {
        current: 0,
    }
});
</script>
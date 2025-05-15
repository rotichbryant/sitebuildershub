<template>
    <LandingLayout>
        <Head title="View Posting" />
        <!-- Main Content Start -->
        <div class="bg-default-2 pt-22 pt-lg-25 pb-13 pb-xxl-32">
            <div class="container">
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
                    <div class="col-12 col-xxl-9 col-lg-9 col-md-8">
                        <div class="bg-white rounded-4 shadow-9">
                        <!-- Tab Section Start -->
                        <ul class="nav border-bottom border-mercury pl-12" id="myTab" role="tablist">
                            <li class="tab-menu-items nav-item pr-12">
                            <a class="active text-uppercase font-size-3 font-weight-bold text-default-color py-3" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Overview</a>
                            </li>
                            <li class="tab-menu-items nav-item pr-12">
                            <a class="text-uppercase font-size-3 font-weight-bold text-default-color py-3" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Contact</a>
                            </li>
                        </ul>
                        <!-- Tab Content -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                                            <div class="p-4">
                                                <InnerImageZoom :src="image" :zoomScale="2" /> 
                                            </div>                                    
                                        </Slide>
                                    </Carousel>
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
                                </div>
                                <!-- Excerpt Start -->
                                <div class="pr-xl-0 pr-xxl-14 p-5 px-xs-12 pt-7 pb-5">
                                    <h4 class="font-size-6 mb-7 mt-5 text-black-2 font-weight-semibold">Description</h4>
                                    <p class="font-size-4 mb-8">{{ posting.description }}</p>
                                </div>
                                <!-- Excerpt End -->
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- Excerpt Start -->
                            <div class="pr-xl-11 p-5 pl-xs-12 pt-9 pb-11">
                                <form action="/">
                                <div class="row">
                                    <div class="col-12 mb-7">
                                    <label for="name3" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Your Name</label>
                                    <input id="name3" type="text" class="form-control" placeholder="Jhon Doe">
                                    </div>
                                    <div class="col-lg-6 mb-7">
                                    <label for="email3" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">E-mail</label>
                                    <input id="email3" type="email" class="form-control" placeholder="example@gmail.com">
                                    </div>
                                    <div class="col-lg-6 mb-7">
                                    <label for="subject3" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Subject</label>
                                    <input id="subject3" type="text" class="form-control" placeholder="Special contract">
                                    </div>
                                    <div class="col-lg-12 mb-7">
                                    <label for="message3" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Message</label>
                                    <textarea name="message" id="message3" placeholder="Type your message" class="form-control h-px-144"></textarea>
                                    </div>
                                    <div class="col-lg-12 pt-4">
                                    <button class="btn btn-primary text-uppercase w-100 h-px-48">Send Now</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- Excerpt End -->
                            </div>
                        </div>
                        <!-- Tab Content End -->
                        <!-- Tab Section End -->
                        </div>
                    </div>
                    <!-- Middle Content -->
                    <!-- Right Sidebar Start -->
                    <div class="col-12 col-xxl-3 col-lg-3 col-md-3 px-0">
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
                    </div>
                    <!-- Right Sidebar End -->
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
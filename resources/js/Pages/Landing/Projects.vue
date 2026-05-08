<template>
    <LandingLayout>
        <Head title="Projects" />
        <template #breadcrumb>
            <ul class="crumb">
                <li><h4><a :href="route('landing.home')">Home</a></h4></li>
                <li><h4><a :href="route('landing.projects')">Projects</a></h4></li>
            </ul>
        </template>          
        <!-- Main Content Start -->
        <div class="bg-default-1 pt-10">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 ">
                            <!-- form -->
                            <!-- <PostingFilter /> -->
                            <div class="ml-lg-0 ml-md-15">
                                <div class="row">
                                    <WhenVisible data="$data.postings" :buffer="500">
                                        <template #fallback>
                                            <div class="col-12 d-flex align-items-center justify-content-center" style="height: 50vh;">
                                                <h6 class="text-primary">
                                                    <i class="fa fa-spinner fa-spin mr-2"></i>
                                                    <span>Loading...</span>
                                                </h6>
                                            </div>  
                                        </template>
                                        <template v-for="(project,index) in $data.projects.data" :key="project.id" >
                                            <Project 
                                                :data="project" 
                                                :delay="(index + 1) * 800"
                                            />                                        
                                        </template>
                                        <template v-if="isEmpty($data.projects.data)" >
                                            <div class="col-12 d-flex align-items-center justify-content-center" style="height: 50vh;" >
                                                <h6 class="text-primary">
                                                    <i class="fa fa-exclamation-circle mr-2"></i>
                                                    <span>Nothing Found Here</span>
                                                </h6>
                                            </div>                                              
                                        </template>
                                        <template v-if="!isEmpty($data.projects.data)" >
                                            <div class="col-md-12 d-flex justify-content-center mt-4">
                                                <nav aria-label="Page navigation">
                                                    <ul class="pagination">
                                                        <li class="page-item" v-bind:class="{ 'disabled': page.url == null, 'active': page.active }" v-for="(page,key) in $data.projects.links" :key="key">
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
                                    </WhenVisible >                                                                         
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
import { Project } from '../../Components/Landing';
import { inject, reactive, ref } from 'vue';
import { isEmpty } from 'lodash';

// import required modules
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

const $toast: any = inject('$toast'); 
const $data: any  = reactive({
    categories:   usePage().props.categories,
    locations:    usePage().props.locations,
    queryParams:  Object.fromEntries(new URLSearchParams(window.location.search).entries()),
    projects:     usePage().props.projects,
    filters:{
        categories:  ref([]),
        cities:      ref([]),
        price_range: String(),
        name:        ref([])
    },
    modules: [Autoplay, Pagination, Navigation],
});

</script>
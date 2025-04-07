<template>
    <LandingLayout>
        <Head title="Postings" />
        <!-- Main Content Start -->
        <div class="bg-default-1 pt-26 pt-lg-28 pb-13 pb-lg-25">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-xs-12">
                    <div class="row">
                        <div class="col-md-4 col-xs-8">
                            <PostingSidebar />
                        </div>
                        <div class="col-md-8 col-xs-12 ">
                            <!-- form -->
                            <PostingFilter />
                            <div class="pt-12 ml-lg-0 ml-md-15">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center result-view-type">
                                        <a class="heading-default-color pl-5 font-size-6 hover-text-hitgray" href="#">
                                            <i class="fa fa-list-ul"></i>
                                        </a>
                                        <a class="heading-default-color pl-5 font-size-6 hover-text-hitgray active" href="#">
                                            <i class="fa fa-th-large"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="pt-6">
                                    <div class="row">
                                        <Posting />
                                    </div>
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
import { Head } from '@inertiajs/vue3';
import { Posting, PostingFilter, PostingSidebar } from '../../Components/Landing';
</script>
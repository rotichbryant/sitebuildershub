<template>
    <LandingLayout>
        <Head title="Postings" />
        <!-- Main Content Start -->
        <div class="bg-default-1 pt-26 pt-lg-28 pb-13 pb-lg-25">
        <div class="container">
            <div class="row">
            <div class="col-12 col-md-4 col-xs-8">
                <!-- Sidebar Start -->
                <div class="widgets mb-11">
                <h4 class="font-size-6 font-weight-semibold mb-6">Job Type</h4>
                <ul class="list-unstyled filter-check-list">
                    <li class="mb-2"><a href="#" class="toggle-item">Full Time</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Part Time</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Contract</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Internship</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Temporary</a></li>
                </ul>
                </div>
                <div class="widgets mb-11 ">
                <div class="d-flex align-items-center pr-15 pr-xs-0 pr-md-0 pr-xl-22">
                    <h4 class="font-size-6 font-weight-semibold mb-6 w-75">Salary Range</h4>
                    <!-- Range Slider -->
                    <div class="slider-price w-25 text-right mr-7">
                    <p class="font-weight-bold">
                        <input class="text-primary font-weight-semibold font-size-4 focus-reset" type="text" id="amount" readonly="">
                    </p>
                    </div>
                </div>
                <div class="graph text-center mx-0 mt-5 position-relative chart-postion">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="range-slider">
                    <div class="pm-range-slider"></div>
                </div>
                </div>
                <div class="widgets mb-11">
                <h4 class="font-size-6 font-weight-semibold mb-6">Experience Level </h4>
                <ul class="list-unstyled filter-check-list">
                    <li class="mb-2"><a href="#" class="toggle-item">All</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Senior</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Mid</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Junior</a></li>
                </ul>
                </div>
                <div class="widgets mb-11">
                <h4 class="font-size-6 font-weight-semibold mb-6">Posted Time</h4>
                <ul class="list-unstyled filter-check-list">
                    <li class="mb-2"><a href="#" class="toggle-item">Anytime</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Last day</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Last 3 days</a></li>
                    <li class="mb-2"><a href="#" class="toggle-item">Last week</a></li>
                </ul>
                </div>
                <!-- Sidebar End -->
            </div>
            <div class="col-12 col-md-8 col-xs-12 ">
                <!-- form -->
                <form action="/" class="search-form search-2-adjustment ml-lg-0 ml-md-15">
                <div class="filter-search-form-2 bg-white rounded-sm shadow-7 pr-6 py-6 pl-6">
                    <div class="filter-inputs">
                    <div class="form-group position-relative w-lg-45 w-xl-40 w-xxl-45">
                        <input class="form-control focus-reset pl-13" type="text" id="keyword" placeholder="UI Designer">
                        <span class="h-100 w-px-50 pos-abs-tl d-flex align-items-center justify-content-center font-size-6">
                        <i
                        class="icon icon-zoom-2 text-primary font-weight-bold"></i>
                    </span>
                    </div>
                    <!-- .select-city starts -->
                    <div class="form-group position-relative w-lg-55 w-xl-60 w-xxl-55">
                        <select name="country" id="country" class="nice-select pl-13 h-100 arrow-3 font-size-4">
                        <option data-display="City, state, zip code or (Remote)">City</option>
                        <option value="">United States of America</option>
                        <option value="">United Arab Emirates</option>
                        <option value="">Bangladesh</option>
                        <option value="">Pakistan</option>
                        </select>
                        <span class="h-100 w-px-50 pos-abs-tl d-flex align-items-center justify-content-center font-size-6">
                        <i
                        class="icon icon-pin-3 text-primary font-weight-bold"></i>
                    </span>
                    </div>
                    <!-- ./select-city ends -->
                    </div>
                    <div class="button-block">
                    <button class="btn btn-primary line-height-reset h-100 btn-submit w-100 text-uppercase">Search</button>
                    </div>
                </div>
                </form>
                <div class="pt-12 ml-lg-0 ml-md-15">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="font-size-4 font-weight-normal text-default-color">
                    <span class="heading-default-color">120</span>
                    results for <span class="heading-default-color">UI Designer</span>
                    </h5>
                    <div class="d-flex align-items-center result-view-type">
                    <a class="heading-default-color pl-5 font-size-6 hover-text-hitgray" href="./search-list-1.html">
                        <i class="fa fa-list-ul"></i>
                    </a>
                    <a class="heading-default-color pl-5 font-size-6 hover-text-hitgray active" href="./search-grid.html">
                        <i class="fa fa-th-large"></i>
                    </a>
                    </div>
                </div>
                <div class="pt-6">
                    <div class="row justify-content-center">
                    <div class="col-12 col-lg-6">
                        <!-- Start Feature One -->
                        <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                        <div class="d-block mb-7">
                            <a href="#"><img src="../../../image/l1/png/feature-brand-1.png" alt=""></a>
                        </div>
                        <a href="#" class="font-size-3 d-block mb-0 text-gray">Google INC</a>
                        <h2 class="mt-n4"><a class="font-size-7 text-black-2 font-weight-bold mb-4" href="">Product Designer</a></h2>
                        <ul class="list-unstyled mb-1 card-tag-list">
                            <li><a href="" class="bg-regent-opacity-15 text-denim font-size-3 rounded-3">
                                <i class="icon icon-pin-3 mr-2 font-weight-bold"></i> Berlyn
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-orange font-size-3 rounded-3">
                                <i class="fa fa-briefcase mr-2 font-weight-bold"></i> Full-time
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-eastern font-size-3 rounded-3">
                                <i class="fa fa-dollar-sign mr-2 font-weight-bold"></i> 80K-90K
                            </a></li>
                        </ul>
                        <p class="mb-7 font-size-4 text-gray">We are looking for Enrollment Advisors who are looking to take 30-35 appointments per week. All leads are pre-scheduled.</p>
                        <div class="card-btn-group">
                            <a class="btn btn-green text-uppercase btn-medium rounded-3" href="#">Apply Now</a>
                            <a class="btn btn-outline-mercury text-black-2 text-uppercase btn-medium rounded-3" href="#"><i
                    class="icon icon-bookmark-2 font-weight-bold mr-4 font-size-4"></i> Save it</a>
                        </div>
                        </div>
                        <!-- End Feature One -->
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- Start Feature One -->
                        <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                        <div class="d-block mb-7">
                            <a href="#"><img src="../../../image/l1/png/feature-brand-2.png" alt=""></a>
                        </div>
                        <a href="#" class="font-size-3 d-block mb-0 text-gray">AirBnb</a>
                        <h2 class="mt-n4"><a class="font-size-7 text-black-2 font-weight-bold mb-4" href="">UI/UX Designer</a></h2>
                        <ul class="list-unstyled mb-1 card-tag-list">
                            <li><a href="" class="bg-regent-opacity-15 text-denim font-size-3 rounded-3">
                                <i class="icon icon-pin-3 mr-2 font-weight-bold"></i> Berlyn
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-orange font-size-3 rounded-3">
                                <i class="fa fa-briefcase mr-2 font-weight-bold"></i> Full-time
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-eastern font-size-3 rounded-3">
                                <i class="fa fa-dollar-sign mr-2 font-weight-bold"></i> 80K-90K
                            </a></li>
                        </ul>
                        <p class="mb-7 font-size-4 text-gray">We are looking for Enrollment Advisors who are looking to take 30-35 appointments per week. All leads are pre-scheduled.</p>
                        <div class="card-btn-group">
                            <a class="btn btn-green text-uppercase btn-medium rounded-3" href="#">Apply Now</a>
                            <a class="btn btn-outline-mercury text-black-2 text-uppercase btn-medium rounded-3" href="#"><i
                    class="icon icon-bookmark-2 font-weight-bold mr-4 font-size-4"></i> Save it</a>
                        </div>
                        </div>
                        <!-- End Feature One -->
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- Start Feature One -->
                        <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                        <div class="d-block mb-7">
                            <a href="#"><img src="../../../image/l1/png/feature-brand-3.png" alt=""></a>
                        </div>
                        <a href="#" class="font-size-3 d-block mb-0 text-gray">Shopify</a>
                        <h2 class="mt-n4"><a class="font-size-7 text-black-2 font-weight-bold mb-4" href="">iOS Developer</a></h2>
                        <ul class="list-unstyled mb-1 card-tag-list">
                            <li><a href="" class="bg-regent-opacity-15 text-denim font-size-3 rounded-3">
                                <i class="icon icon-pin-3 mr-2 font-weight-bold"></i> Berlyn
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-orange font-size-3 rounded-3">
                                <i class="fa fa-briefcase mr-2 font-weight-bold"></i> Full-time
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-eastern font-size-3 rounded-3">
                                <i class="fa fa-dollar-sign mr-2 font-weight-bold"></i> 80K-90K
                            </a></li>
                        </ul>
                        <p class="mb-7 font-size-4 text-gray">We are looking for Enrollment Advisors who are looking to take 30-35 appointments per week. All leads are pre-scheduled.</p>
                        <div class="card-btn-group">
                            <a class="btn btn-green text-uppercase btn-medium rounded-3" href="#">Apply Now</a>
                            <a class="btn btn-outline-mercury text-black-2 text-uppercase btn-medium rounded-3" href="#"><i
                    class="icon icon-bookmark-2 font-weight-bold mr-4 font-size-4"></i> Save it</a>
                        </div>
                        </div>
                        <!-- End Feature One -->
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- Start Feature One -->
                        <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                        <div class="d-block mb-7">
                            <a href="#"><img src="../../../image/l1/png/feature-brand-4.png" alt=""></a>
                        </div>
                        <a href="#" class="font-size-3 d-block mb-0 text-gray">Uber</a>
                        <h2 class="mt-n4"><a class="font-size-7 text-black-2 font-weight-bold mb-4" href="">Creative Director </a></h2>
                        <ul class="list-unstyled mb-1 card-tag-list">
                            <li><a href="" class="bg-regent-opacity-15 text-denim font-size-3 rounded-3">
                                <i class="icon icon-pin-3 mr-2 font-weight-bold"></i> Berlyn
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-orange font-size-3 rounded-3">
                                <i class="fa fa-briefcase mr-2 font-weight-bold"></i> Full-time
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-eastern font-size-3 rounded-3">
                                <i class="fa fa-dollar-sign mr-2 font-weight-bold"></i> 80K-90K
                            </a></li>
                        </ul>
                        <p class="mb-7 font-size-4 text-gray">We are looking for Enrollment Advisors who are looking to take 30-35 appointments per week. All leads are pre-scheduled.</p>
                        <div class="card-btn-group">
                            <a class="btn btn-green text-uppercase btn-medium rounded-3" href="#">Apply Now</a>
                            <a class="btn btn-outline-mercury text-black-2 text-uppercase btn-medium rounded-3" href="#"><i
                    class="icon icon-bookmark-2 font-weight-bold mr-4 font-size-4"></i> Save it</a>
                        </div>
                        </div>
                        <!-- End Feature One -->
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- Start Feature One -->
                        <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                        <div class="d-block mb-7">
                            <a href="#"><img src="../../../image/l1/png/feature-brand-5.png" alt=""></a>
                        </div>
                        <a href="#" class="font-size-3 d-block mb-0 text-gray">Facebook</a>
                        <h2 class="mt-n4"><a class="font-size-7 text-black-2 font-weight-bold mb-4" href="">Marketing Manager </a></h2>
                        <ul class="list-unstyled mb-1 card-tag-list">
                            <li><a href="" class="bg-regent-opacity-15 text-denim font-size-3 rounded-3">
                                <i class="icon icon-pin-3 mr-2 font-weight-bold"></i> Berlyn
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-orange font-size-3 rounded-3">
                                <i class="fa fa-briefcase mr-2 font-weight-bold"></i> Full-time
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-eastern font-size-3 rounded-3">
                                <i class="fa fa-dollar-sign mr-2 font-weight-bold"></i> 80K-90K
                            </a></li>
                        </ul>
                        <p class="mb-7 font-size-4 text-gray">We are looking for Enrollment Advisors who are looking to take 30-35 appointments per week. All leads are pre-scheduled.</p>
                        <div class="card-btn-group">
                            <a class="btn btn-green text-uppercase btn-medium rounded-3" href="#">Apply Now</a>
                            <a class="btn btn-outline-mercury text-black-2 text-uppercase btn-medium rounded-3" href="#"><i
                    class="icon icon-bookmark-2 font-weight-bold mr-4 font-size-4"></i> Save it</a>
                        </div>
                        </div>
                        <!-- End Feature One -->
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- Start Feature One -->
                        <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                        <div class="d-block mb-7">
                            <a href="#"><img src="../../../image/l1/png/feature-brand-6.png" alt=""></a>
                        </div>
                        <a href="#" class="font-size-3 d-block mb-0 text-gray">Oculus</a>
                        <h2 class="mt-n4"><a class="font-size-7 text-black-2 font-weight-bold mb-4" href="">Software Engineer</a></h2>
                        <ul class="list-unstyled mb-1 card-tag-list">
                            <li><a href="" class="bg-regent-opacity-15 text-denim font-size-3 rounded-3">
                                <i class="icon icon-pin-3 mr-2 font-weight-bold"></i> Berlyn
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-orange font-size-3 rounded-3">
                                <i class="fa fa-briefcase mr-2 font-weight-bold"></i> Full-time
                            </a></li>
                            <li><a href="" class="bg-regent-opacity-15 text-eastern font-size-3 rounded-3">
                                <i class="fa fa-dollar-sign mr-2 font-weight-bold"></i> 80K-90K
                            </a></li>
                        </ul>
                        <p class="mb-7 font-size-4 text-gray">We are looking for Enrollment Advisors who are looking to take 30-35 appointments per week. All leads are pre-scheduled.</p>
                        <div class="card-btn-group">
                            <a class="btn btn-green text-uppercase btn-medium rounded-3" href="#">Apply Now</a>
                            <a class="btn btn-outline-mercury text-black-2 text-uppercase btn-medium rounded-3" href="#"><i
                    class="icon icon-bookmark-2 font-weight-bold mr-4 font-size-4"></i> Save it</a>
                        </div>
                        </div>
                        <!-- End Feature One -->
                    </div>
                    </div>
                </div>
                <div class="text-center pt-5 pt-lg-13">
                    <a class="text-green font-weight-bold text-uppercase font-size-3 d-flex align-items-center justify-content-center" href="#">Load More <i class="fas fa-sort-down ml-3 mt-n2 font-size-4"></i>
                    </a>
                </div>
                </div>
                <!-- form end -->
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
</script>
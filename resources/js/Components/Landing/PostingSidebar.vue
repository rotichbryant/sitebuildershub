<template>
    <div>
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
</template>
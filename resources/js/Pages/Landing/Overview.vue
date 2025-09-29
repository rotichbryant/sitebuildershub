<template>
    <LandingLayout>
        <Head title="Overview" />
        <div class="container py-10">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-7">
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-sm-6">
                            <!-- Single Category -->
                            <a href="#" class="media bg-white rounded-4 pl-8 pt-9 pb-9 pr-7 hover-shadow-1 mb-9 shadow-8">
                            <div class="text-blue bg-blue-opacity-1 circle-56 font-size-6 mr-7">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <!-- Category Content -->
                            <div class="">
                                <h5 class="font-size-8 font-weight-semibold text-black-2 line-height-reset font-weight-bold mb-1"><span class="counter">{{ stats.postings }}</span></h5>
                                <p class="font-size-4 font-weight-normal text-gray mb-0">Postings</p>
                            </div>
                            </a>
                            <!-- End Single Category -->
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 rounded-4 shadow-8 p-9">
                        <div class="card-body">
                            <h4>Postings created for the past 12 months</h4>
                            <CChart
                                type="line"
                                :wrapper="true"
                                :data="{
                                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                    datasets: [
                                    {
                                        label: 'My First dataset',
                                        backgroundColor: 'rgba(220, 220, 220, 0.2)',
                                        borderColor: 'rgba(220, 220, 220, 1)',
                                        pointBackgroundColor: 'rgba(220, 220, 220, 1)',
                                        pointBorderColor: '#fff',
                                        data: [40, 20, 12, 39, 10, 40, 39]
                                    },
                                    {
                                        label: 'My Second dataset',
                                        backgroundColor: 'rgba(151, 187, 205, 0.2)',
                                        borderColor: 'rgba(151, 187, 205, 1)',
                                        pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                                        pointBorderColor: '#fff',
                                        data: [50, 12, 28, 29, 7, 25, 12]
                                    }
                                    ]
                                }"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>    
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head, usePage } from '@inertiajs/vue3';
import { CChart } from '@coreui/vue-chartjs';
import { computed } from 'vue';

const stats: any = computed(() => usePage().props.stats);

</script>
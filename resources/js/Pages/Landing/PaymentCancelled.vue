<template>
    <LandingLayout>
        <Head title="Payment Successful" />
        <div class="bg-default-2 pt-22 pt-lg-25 pb-8 pb-xxl-20">
            <div class="container">
                <div class="row">
                    <!-- Centered Message -->
                    <div class="col-md-6 col-12 mx-auto">
                        <div class="bg-white rounded-4 shadow-9 card border-danger">
                            <!-- Header -->
                            <div class="p-5 px-xs-12 pt-7 pb-5 text-center border-danger">
                                <h4 class="font-size-12 mb-4 text-danger animate animate__shakeX">
                                <i class="fa fa-times-circle fa-2x"></i>
                                </h4>
                                <h4 class="font-size-7 mb-3 text-danger font-weight-semibold">Transaction Cancelled</h4>
                                <h2 class="font-size-9 mb-4 text-danger font-weight-bold">KES 200</h2>
                                <p class="text-muted font-size-3">Your payment was not completed</p>
                            </div>

                            <!-- Cancelled Details -->
                            <div class="border-top p-5 pt-4">
                                <ul class="list-unstyled font-size-4 text-black-2">
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Transaction ID:</span>
                                    <span>#TXN123456789</span>
                                </li>
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Date:</span>
                                    <span>22 July 2025</span>
                                </li>
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Payment Method:</span>
                                    <span>Mpesa</span>
                                </li>
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Status:</span>
                                    <span class="text-danger">Cancelled</span>
                                </li>
                                <li class="d-flex justify-content-between py-2">
                                    <span>Customer:</span>
                                    <span>John Doe</span>
                                </li>
                                </ul>
                            </div>

                            <!-- Footer -->
                            <div class="border-top p-4 text-center">
                                <small class="text-muted">No charges were made for this transaction</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head } from '@inertiajs/vue3';
</script>
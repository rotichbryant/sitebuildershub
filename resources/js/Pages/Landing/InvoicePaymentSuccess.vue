<template>
    <LandingLayout>
        <Head :title="`Invoice Payment Successful`" />
        <div class="bg-default-2 pt-22 pt-lg-25 pb-8 pb-xxl-20">
            <div class="container">
                <div class="row">
                    <!-- Centered Receipt -->
                    <div class="col-md-6 col-12 mx-auto">
                        <div class="bg-white rounded-4 shadow-9 card border-success p-5">
                        <!-- Header -->
                        <div class="p-5 px-xs-12 pt-7 pb-5 border-success text-center">
                            <h4 class="font-size-12 mb-4 text-success animate animate__tada">
                            <i class="fa fa-check-circle"></i>
                            </h4>
                            <h4 class="font-size-10 mb-3 text-success font-weight-semibold">Payment Successful</h4>
                            <h2 class="font-size-9 mb-4 text-success font-weight-bold"></h2>
                            <p class="text-muted font-size-3">Thank you for your payment</p>
                        </div>

                        <!-- Receipt Details -->
                        <div class="border-top p-5 pt-4">
                            <ul class="list-unstyled font-size-4 text-black-2">
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Invoice Number</span>
                                    <span>#{{ $props.invoice.invoice_number }}</span>
                                </li>
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Invoice Purpose</span>
                                    <span>{{ $data.purpose }}</span>
                                </li>                                    
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Transaction ID:</span>
                                    <span>{{ $props.transaction.confirmation_code }}</span>
                                </li>
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Date:</span>
                                    <span>{{ $props.transaction.paid_at }}</span>
                                </li>
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>Payment Method:</span>
                                    <span>{{ $props.transaction.payment_method }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Footer -->
                        <div class="border-top p-4 text-center">
                            <small class="text-muted">A copy of this receipt has been sent to your email</small>
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
import { has } from 'lodash';
import { onBeforeMount, onMounted, reactive } from 'vue';

const $props: any = defineProps({
    invoice:     Object,
    transaction: Object,
});

const $data: any = reactive({
    purpose: ""
});

onBeforeMount(
    () => {
        $data.purpose = $props.invoice.source_type == 'subscription' ? 'Payment for subscription' : 'Payment for advert placement'
    }
)

onMounted( 
    () => setTimeout( 
        () => { 
            window.location.href = route('landing.profile',{tab:'invoices'})          
        },
        1500
    ) 
);
</script>
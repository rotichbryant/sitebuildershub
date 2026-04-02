<template>
    <div class="col-12">
        <h5>Invoices</h5>
        <div class="row">
            <div class="col-md-6 col-xs-12" v-for="(invoice,index) in invoices.data">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-10">
                        <div class="p-5 px-xs-12 pt-7 pb-5 text-center">
                            <p 
                                class="font-size-10 mb-4" 
                                v-bind:class="{
                                    'text-success': invoice.status == 'paid',
                                    'text-warning': invoice.status == 'unpaid',
                                    'text-muted':   invoice.status == 'cancelled',
                                }"
                            >
                                <i class="fa fa-file"></i>
                            </p>
                            <p class="font-size-6 mb-3 text-success font-weight-semibold">#{{ invoice.invoice_number }}</p>
                            <a class="btn btn-outline-primary" v-if="!isNull(invoice.pending_transaction)" :href="invoice.pending_transaction.payment_url">Pay</a>
                        </div>                        
                        <ul class="list-unstyled font-size-4 text-black-2">
                            <li class="d-flex justify-content-between py-2">
                                <span>Invoice Number</span>
                                <span>#{{ invoice.invoice_number }}</span>
                            </li>                            
                            <li class="d-flex justify-content-between py-2">
                                <span>Date</span>
                                <span>{{ invoice.created_at }}</span>
                            </li>  
                            <li class="d-flex justify-content-between py-2">
                                <span>Amount</span>
                                <span>{{ invoice.currency_amount }}</span>
                            </li>                              
                            <li class="d-flex justify-content-between py-2">
                                <span>Type</span>
                                <span>{{ invoice.source_type }}</span>
                            </li>                                                                                                   
                        </ul>
                    </div>
                </div>                
            </div>
            <div class="col-12 mt-8" v-if="!isEmpty(invoices.data)" >
                <div class="col-md-12 d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item" v-bind:class="{ 'disabled': page.url == null, 'active': page.active }" v-for="(page,key) in invoices.links" :key="key">
                                <a 
                                    class="page-link" 
                                    :href="page.url"                             
                                    v-html="page.label"
                                ></a>
                            </li>
                        </ul>
                    </nav>
                </div>                                            
            </div>
        </div> 
    </div>   
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import { isEmpty, isNull } from 'lodash';
import { computed} from 'vue';

const $props: any = usePage().props

const invoices: any = computed( () => $props.invoices );

</script>
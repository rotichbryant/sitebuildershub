<template>
    <LandingLayout>
        <Head title="Subscription Checkout" />        
        <div class="container py-10">
            <div class="row justify-content-center">

                <!-- Left: Billing Cycle Selection -->
                <div class="col-lg-8 col-md-6 col-xs-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-20 px-15">
                            <h4 class="mb-4">Subscription Checkout</h4>
                            <form id="billingForm">
                                <div class="mb-3">
                                    <label class="form-label">Billing Cycle</label>
                                    <div class="btn-group w-100" role="group">
                                        <button 
                                            class="btn mr-2" 
                                            type="button"
                                            @click="subscription_type('monthly')"
                                            v-bind:class="{
                                                'btn-outline-primary': $data.form.subscription_type != 'monthly',
                                                'btn-primary':         $data.form.subscription_type == 'monthly'
                                            }"
                                        >Monthly</button>
                                       <button 
                                            class="btn mr-2" 
                                            type="button"
                                            @click="subscription_type('yearly')"
                                            v-bind:class="{
                                                'btn-outline-primary': $data.form.subscription_type != 'yearly',
                                                'btn-primary':         $data.form.subscription_type == 'yearly'
                                            }"
                                        >Yearly</button>                                        
                                    </div>
                                </div>

                                <div class="my-6" v-if="!isEmpty($data.form.subscription_type)">
                                    <h6 class="mb-3 text-center">Bill Overview</h6>
                                    <div class="row">
                                        <div class="col-lg-6 mx-auto">
                                            <ul class="list-unstyled"> 
                                                <li class="mb-2 text-black-2 d-flex font-size-4 justify-content-between">                                        
                                                    <span><i class="fas fa-check font-size-3 text-black-2 mr-3"></i>Start Date:</span>
                                                    <span><strong>{{ $data.selection.start_date }}</strong></span>
                                                </li>
                                                <li class="mb-2 text-black-2 d-flex font-size-4 justify-content-between">                                        
                                                    <span><i class="fas fa-check font-size-3 text-black-2 mr-3"></i>End Date:</span>
                                                    <span><strong>{{ $data.selection.end_date }}</strong></span>
                                                </li>                                                                                                
                                                <li class="mb-2 text-black-2 d-flex font-size-4 justify-content-between">                                        
                                                    <span><i class="fas fa-check font-size-3 text-black-2 mr-3"></i>Price:</span>
                                                    <span><strong>{{ subscription.currency_price }}</strong></span>
                                                </li>
                                                <li class="mb-2 text-black-2 d-flex font-size-4 justify-content-between">                                        
                                                    <span><i class="fas fa-check font-size-3 text-black-2 mr-3"></i>Months:</span>
                                                    <span><strong>{{ $data.selection.months }}</strong></span>
                                                </li>
                                                <li class="mb-2 text-black-2 d-flex font-size-4 justify-content-between">                                        
                                                    <span><i class="fas fa-check font-size-3 text-black-2 mr-3"></i>Total:</span>
                                                    <span><strong>{{ subscription.price * $data.selection.months }}</strong></span>
                                                </li>                                                                                                                                                                                                                                            
                                            </ul>  
                                        </div>
                                    </div>                                  
                                </div>

                                <button type="button" class="btn btn-primary w-100" id="checkoutBtn">
                                Complete Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-20 px-15">
                            <h4 class="text-primary">{{ subscription.name }}</h4>
                            <h5>{{ subscription.currency_price }}</h5>
                            <p>{{ subscription.description }}</p>
                            <p>Features</p>
                            <ul class="list-unstyled">
                                <li class="mb-6 text-black-2 d-flex font-size-4">
                                    <i class="fas fa-check font-size-3 text-black-2 mr-3"></i> 
                                    {{ subscription.features.max_posts }} Max postings
                                </li>
                                <li class="mb-6 text-black-2 d-flex font-size-4" v-if="subscription.features.for_businesses">
                                    <i class="fas fa-check font-size-3 text-black-2 mr-3"></i> 
                                    For Businesses
                                </li>
                                <li class="mb-6 text-black-2 d-flex font-size-4" v-if="subscription.features.for_professionals">
                                    <i class="fas fa-check font-size-3 text-black-2 mr-3"></i> 
                                    For Professionals
                                </li>                                                                
                            </ul>
                        </div>
                    </div>
                </div>                  
            </div>
        </div>       
    </LandingLayout>      
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { isEmpty } from 'lodash';
import moment from 'moment';
import { computed, reactive } from 'vue';
import { toast } from 'vue3-toastify';

const pageProps:  any = computed( () => usePage().props );

const subscription: any = computed( () => usePage().props.subscription );

const $data: any  = reactive({
    selection: {
        start_date:        String(),
        end_date:          String(),
        months:            1
    },
    form: {
        subscription_id:   String(),
        subscription_type: String(),
    }
});

/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
const submit = async () => {
    const form    = { 
        ...$data.form, 
        _token: pageProps.value.csrf_token
    };

    useForm(form).post(
        route('landing.subscription.store'), 
        {
            onSuccess: ({ props}: any) => {
                toast.success(props.flash.message);
                create_transaction()
            },
        }
    );        
};

const create_transaction = async () => {
    router.put(
        route('landing.transactions.subscription.create',{ subscription: pageProps.subscription.id }),
        {},
        {
            onSuccess: ({ props: { data: { subscription } } }: any) => {
                window.location.href = subscription.redirect_url;
            }
        }
    );
}

const subscription_type = (type: string) => {
    $data.form.subscription_type = type;
    $data.selection.months       = type == 'yearly' ? 12 : 1;
    $data.selection.start_date   = moment().format('Do MMMM YYYY');
    $data.selection.end_date     = type == 'yearly' ? moment().add(12,'months').format('Do MMMM YYYY') : moment().add(1,'months').format('Do MMMM YYYY')
}
</script>
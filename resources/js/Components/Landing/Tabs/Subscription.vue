<template>
    <div class="col-12">
        <h5>Subscription</h5>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-10">
                        <div class="p-5 px-xs-12 pt-7 pb-5 text-center">
                            <p class="font-size-10 mb-4 text-success">
                                <i class="fa fa-check-circle"></i>
                            </p>
                            <p class="font-size-6 mb-3 text-success font-weight-semibold">{{ active_subscription.name }}</p>
                            <p 
                                class="font-size-4 mb-3 font-weight-semibold" 
                                v-bind:class="{ 
                                    'text-success': check_expiry(subscription.end_date),
                                    'text-warning': check_expiry(subscription.end_date),
                                }"
                            >Expiry Date: {{ subscription.end_date }}</p>
                        </div>                        
                        <ul class="list-unstyled font-size-4 text-black-2">
                            <li class="d-flex justify-content-between py-2" v-for="(feature,key) of active_subscription.features">
                                <span>{{ capitalize(key.replace('_',' ')) }}</span>
                                <span class="text-success">
                                    <template v-if="feature.constructor == Boolean"><i class="fa fa-check-circle"></i></template>
                                    <template v-if="feature.constructor == Number">{{ feature }}</template>
                                    <template v-if="feature.constructor == String">{{ feature }}</template>
                                </span>
                            </li>                                                                                                                            
                        </ul>
                    </div>
                </div>                                
            </div>
        </div>        
    </div>    
</template>
<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import { computed} from 'vue';
import { capitalize } from 'lodash';
import moment from 'moment';

const subscription: any        = computed( () => usePage().props.subscription );
const active_subscription: any = computed( () => usePage().props.active_subscription );

const check_expiry = (date: string) => {
    let diff = moment().diff(date);

    console.log(diff);

    return true
}

</script>
<template>
    <LandingLayout>
      <Head title="Subscriptions" />
      <div class="pt-md pt-10">
        <!-- pricing area function start -->
        <!-- pricing section -->
        <div class="pricing-area">
          <div class="container pt-12 pt-lg-24 pb-13 pb-lg-25">
            <div class="row justify-content-center">
              <div class="col-xxl-6 col-lg-7 col-md-9" data-aos="fade-in" data-aos-duration="1000" data-aos-once="true">
                <!-- section-title start -->
                <div class="section-title text-center mb-12 mb-lg-18 mb-lg-15 pb-lg-15 pb-0">
                  <h2 class="mb-9">Check our amazing plans, choose the best one for you.</h2>
                  <p class="text-default-color font-size-4 px-5 px-md-10 px-lg-15 px-xl-24 px-xxl-22">Complete Design
                    Toolkit – huge collection of elements, rich customization options, flexible layouts.</p>
                </div>
                <!-- section-title end -->
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-xxl-10 col-xl-11">
                <div class="row justify-content-center">
                  <WhenVisible data="$props.subscriptions">
                      <template #fallback>
                          <div class="col-12 d-flex align-items-center justify-content-center" style="height: 50vh;">
                              <h6 class="text-primary">
                                  <i class="fa fa-spinner fa-spin mr-2"></i>
                                  <span>Loading...</span>
                              </h6>
                          </div>  
                      </template>
                      <template v-for="(subscription,index) in $props.subscriptions" :key="subscription.id" >
                        <div class="col-lg-4 col-md-6 col-xs-9" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
                          <!-- card start -->
                          <div class="card border-mercury rounded-8 mb-lg-3 mb-9 px-xl-12 px-lg-8 px-12 pb-12 hover-shadow-hitgray">
                            <!-- card-header start -->
                            <div class="card-header bg-transparent border-hit-gray-opacity-5 text-center pt-11 pb-8">
                              <div class="pricing-title text-center">
                                <h4 class="font-weight-semibold font-size-8 text-black-2">{{ subscription.name }}</h4>
                              </div>
                              <h3 class="mt-8 text-dodger">
                                {{ subscription.currency_price }}
                              </h3>
                              <p>per month</p>
                            </div>
                            <!-- card-header end -->
                            <!-- card-body start -->
                            <div class="card-body px-0 pt-11 pb-15">
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
                            <!-- card-body end -->
                            <!-- card-footer end -->
                            <div class="card-footer bg-transparent border-0 px-0 py-0">
                              <button 
                                class="btn btn-green btn-h-60 text-white rounded-5 btn-block text-uppercase" 
                                :disabled="!isNull(auth_subscription) && auth_subscription.id == subscription.id"
                                @click="router.visit(route('landing.subscription.checkout',{ subscription: subscription.id }))"
                              > Subscribe </button>
                            </div>
                            <!-- card-footer end -->
                          </div>
                          <!-- card end -->
                        </div>                                        
                      </template>
                      <template v-if="isEmpty($props.subscriptions)" >
                          <div class="col-12 d-flex align-items-center justify-content-center" style="height: 50vh;" >
                              <h6 class="text-primary">
                                  <i class="fa fa-exclamation-circle mr-2"></i>
                                  <span>Nothing Found Here</span>
                              </h6>
                          </div>                                              
                      </template>                   
                  </WhenVisible>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- pricing area function end -->
      </div>
    </LandingLayout>
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head, router, WhenVisible } from '@inertiajs/vue3';
import { isEmpty, isNull } from 'lodash';
import { computed } from 'vue';

const $props: any       = defineProps({ auth: Object, subscriptions: Array });
const auth_subscription = computed( () => !isEmpty($props.auth) ? $props.auth.user.subscription : null )
</script>
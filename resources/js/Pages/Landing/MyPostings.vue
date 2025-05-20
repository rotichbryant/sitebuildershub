<template>
    <LandingLayout>
        <Head title="My Postings" />
        <div class="container pt-26">
            <div class="row">
                <div class="col-12">
                    <div class="mb-18">
                        <div class="row mb-6 align-items-center">
                            <div class="col-lg-6 mb-lg-0 mb-4">
                                <h3 class="font-size-6 mb-0">Postings</h3>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex flex-wrap align-items-center justify-content-lg-end">
                                    <a class="btn btn-primary" :href="route('landing.mypostings.create')">Create Posting</a>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white shadow-8 pt-7 rounded pb-9 px-11">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="pl-0 border-0 font-size-4 font-weight-normal">Title</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">Category</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">Location</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">Price</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">Quantity</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">Created On</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border border-color-2" v-if="isEmpty(postings.data)">
                                            <td class="table-y-middle py-7 min-width-px-155 text-center" colspan="7">
                                                <h3 class="font-size-4 font-weight-normal text-black-2 mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>No postings found</h3>
                                            </td>
                                        </tr>
                                        <tr class="border border-color-2" v-for="(post,index) in postings.data"  v-if="!isEmpty(postings.data)">
                                            <th scope="row" class="pl-6 border-0 py-7 min-width-px-235">
                                                <div class="">
                                                    <a href="jobdetails.html" class="font-size-4 mb-0 font-weight-semibold text-black-2">{{ post.title }}</a>
                                                </div>
                                            </th>
                                            <td class="table-y-middle py-7 min-width-px-135">
                                                <h3 class="font-size-4 font-weight-normal text-black-2 mb-0">
                                                    {{ post.category.name }} <br>
                                                    <span class="badge badge-success badge-outline">{{ post.sub_category.name }}</span>
                                                </h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-125">
                                                <h3 class="font-size-4 font-weight-normal text-black-2 mb-0">
                                                    {{ post.town }} <br>
                                                    <span class="badge badge-info badge-outline">{{ post.county }}</span>
                                                </h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-155">
                                                <h3 class="font-size-4 font-weight-normal text-black-2 mb-0">{{ post.price }}</h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-155">
                                                <h3 class="font-size-4 font-weight-normal text-black-2 mb-0">{{ post.quantity }}</h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-205">
                                                <h3 class="font-size-4 font-weight-bold text-black-2 mb-0">{{ post.created_at }}</h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-80">
                                                <a :href="route('landing.mypostings.show',{ posting: post.id })" class="font-size-3 font-weight-bold text-green text-uppercase">Edit</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-2 d-flex justify-content-center" v-if="!isEmpty(postings.data)">
                                <nav aria-label="Page navigation example" >
                                    <ul class="pagination pagination-hover-primary rounded-0 ml-n2">
                                        <li class="page-item" v-for="(page,index) in postings.links">
                                            <template v-if="page.url != null">
                                                <a class="page-link rounded-0 border-0 px-3" :href="page.url" aria-label="Previous" v-if="page.label.includes('Previous')"><i class="fas fa-chevron-left"></i></a>                                             
                                                <a class="page-link border-0 font-size-4 font-weight-semibold px-3 active" v-if="page.active" :href="page.url">{{ page.label }}</a>
                                                <a class="page-link border-0 font-size-4 font-weight-semibold px-3" v-else :href="page.url">{{ page.label }}</a>   
                                                <a class="page-link rounded-0 border-0 px-3" :href="page.url" aria-label="Next" v-if="page.label.includes('Next')"><i class="fas fa-chevron-right"></i></a>                                             
                                            </template>
                                        </li>
                                    </ul>
                                </nav>
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
import { Head, usePage } from '@inertiajs/vue3';
import { isEmpty } from 'lodash';
import { computed, reactive } from 'vue';

const $data = reactive({
    modals: {
        create: false
    }
});

const postings: any = computed( () => usePage().props.postings );

</script>
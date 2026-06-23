<template>
    <LandingLayout>
        <Head title="My Postings" />
        <template #breadcrumb>
            <ul class="crumb">
                <li><h4><a :href="route('landing.home')">Home</a></h4></li>
                <li><h4><a :href="route('landing.mypostings')">My Postings</a></h4></li>
            </ul>
        </template>        
        <div class="container py-10">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-6 align-items-center mb-9">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <h3 class="font-size-6 mb-0">Postings</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex flex-wrap align-items-center justify-content-lg-end">
                                <a class="btn btn-primary" :href="route('landing.mypostings.create')">Create Posting</a>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="col-12">
                    <div class="row">
                        <template v-for="(posting,index) in postings.data">
                            <div class="col-lg-4 col-md-6">
                                <!-- Start Feature One -->
                                <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                                    <div class="d-block mb-7" style="height: 30vh;">
                                        <img :src="posting.link_images[0]" :alt="posting.title" style="object-fit: cover; width: 100%; height: 100%;"/>
                                    </div>
                                    <h4 class="mt-n4">{{ posting.title }}</h4>
                                    <p class="mb-7 font-size-4 text-gray">  
                                        {{ posting.created_at }}
                                    </p>
                                    <div class="col-12 px-0 d-flex justify-content-between">
                                        <a class="btn btn-outline-green text-uppercase btn-medium rounded-3 w-100" :href="route('landing.mypostings.show',{ posting: posting.id })">View</a>
                                        <a href="#" class="btn btn-outline-danger text-uppercase btn-medium rounded-3 ml-2 w-100" @click="$delete(posting)">Delete</a>
                                    </div>
                                </div>
                            </div>                            
                        </template>
                    </div>
                </div>
            </div>
        </div>        
    </LandingLayout>    
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head, router, usePage } from '@inertiajs/vue3';
import { isEmpty } from 'lodash';
import { computed, inject, reactive } from 'vue';

const $swal: any  = inject('$swal');  
const $toast: any = inject('$toast');  

const $data = reactive({
    loaders:{
        fetch: false
    },
    modals: {
        create: false
    }
});

const $props: any = defineProps({
    flash:         Object
});

const postings: any = computed( () => usePage().props.postings );

const $delete = async (value:any) => {
    // Show a confirmation dialog to the user
    const { isConfirmed } = await $swal.fire({
        icon:  'question', // Icon to display in the dialog
        title: 'Delete Posting', // Title of the dialog
        text:  `Are you sure you want to delete ${value.title}?`, // Text content of the dialog
        showCancelButton: true // Whether to show a "Cancel" button
    });

    // If the user does not confirm, exit the function
    if (!isConfirmed) { return; }

    // Fetch the categories from the server
    router.delete(
        route('landing.mypostings.delete',{ posting: value.id }),
        {
            onSuccess: () => {
                // Post message
                $toast.success($props.flash.message);   
            },
            onError: (error) => {
                // Set the loading flag
                $data.loaders.fetch = false;
            }
        }
    );
}
</script>
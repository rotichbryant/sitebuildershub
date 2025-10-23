<template>
    <div class="col-12 col-md-4">
        <!-- Start Feature One -->
        <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9">
            <div class="d-block mb-7" style="height: 30vh;">
                <img :src="posting.images[0]" :alt="posting.title" style="object-fit: cover; width: 100%; height: 100%;"/>
            </div>
            <h2 class="mt-n4">
                <a class="font-size-7 text-black-2 font-weight-bold mb-4" href="">{{ posting.title }}</a>
            </h2>
            <p class="mb-7 font-size-4 text-gray">  
                <i class="fas fa-map-marker-alt mr-2"></i> 
                {{ posting.town }}, {{ posting.county }}
            </p>                        
            <a class="btn btn-outline-green text-uppercase btn-medium rounded-3 w-100" :href="route('landing.postings.view', { title: decodeURIComponent(posting.title) })">View</a>
        </div>
        <!-- End Feature One -->
    </div>    
</template>
<script lang="ts" setup>
import { computed, defineProps } from 'vue';

const props: any = defineProps({ 
    data: {
        default:  Object(),
        type:     Object,
        required: true
    },
    delay: {
        default:  0,
        type:     Number,
        required: false
    }
});

const posting: any = computed( () => props.data );

</script>
<template>
    <div class="col-lg-4 col-md-6">
        <a :href="route('landing.postings.view', { title: decodeURIComponent(posting.title) })">
            <!-- Start Feature One -->
            <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                <div class="d-block mb-7" style="height: 30vh;">
                    <img :src="posting.link_images[0]" :alt="posting.title" style="object-fit: cover; width: 100%; height: 100%;"/>
                </div>
                <h4 class="mt-n4">{{ posting.title }}</h4>
                <p class="mb-7 font-size-4 text-gray"> {{ posting.description.substring(0, 50) }}... </p>
                <!-- <ul class="list-unstyled mb-1 card-tag-list">
                    <li v-for="(value, index) in posting.categories" :key="index" class="mr-3 mb-2 d-inline-block">
                        <a :href="route('landing.postings')" class="bg-regent-opacity-15 text-muted font-size-2 rounded-3">
                            {{ value.sub_category.name }}
                        </a>
                    </li>
                </ul> -->
                <p class="mb-7 font-size-4 text-gray">  
                    <i class="fas fa-map-marker-alt mr-2"></i> 
                    {{ posting.town }}, {{ posting.county }}
                </p>
                <a class="btn btn-outline-green text-uppercase btn-medium rounded-3 w-100" :href="route('landing.postings.view', { title: decodeURIComponent(posting.title) })">View</a>
            </div>
        </a>
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
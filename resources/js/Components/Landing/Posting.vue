<template>
    <div class="col-lg-4 col-md-6">
        <a :href="route('landing.postings.show', { posting: posting.id })">
            <!-- Start Feature One -->
            <div class="bg-white px-8 pt-9 pb-7 rounded-4 mb-9 feature-cardOne-adjustments">
                <div class="d-block mb-7"><img :src="posting.images[0]" :alt="posting.title" width="100%"></div>
                <h3 class="mt-n4">{{ posting.title }}</h3>
                <ul class="list-unstyled mb-1 card-tag-list">
                    <li>
                        <a href="javascript:void(0);" class="bg-regent-opacity-15 text-denim font-size-3 rounded-3">
                            <i class="far fa-folder mr-2"></i> {{ posting.category.name }}
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="bg-regent-opacity-15 text-orange font-size-3 rounded-3">
                            <i class="fas fa-indent mr-2"></i> {{ posting.sub_category.name }}
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="bg-regent-opacity-15 text-primary font-size-3 rounded-3">
                            KSH {{ posting.price }}
                        </a>
                    </li>
                </ul>
                <p class="mb-7 font-size-4 text-gray"> {{ posting.description.substring(0, 200) }}... </p>
                <p class="mb-7 font-size-4 text-gray">  
                    <i class="fas fa-map-marker-alt mr-2"></i> 
                    {{ posting.town }}, {{ posting.county }}
                </p>
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
    }
});

const posting: any = computed( () => props.data );

</script>
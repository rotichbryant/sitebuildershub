<template>
    <AuthenticatedLayout>
        <Head title="Postings" />
        <CRow>
            <CCol md="12">
                <h4>View Posting</h4>
            </CCol>
            <CCol md="12">
                <CRow>
                    <CCol md="8" xs="12">
                        <Carousel v-bind="carouselConfig">
                            <Slide v-for="slide in 10" :key="slide">
                                <div class="carousel__item">{{ slide }}</div>
                            </Slide>

                            <template #addons>
                                <Navigation />
                                <Pagination />
                            </template>
                        </Carousel>
                    </CCol>
                    <CCol md="4" xs="12"></CCol>
                </CRow>
            </CCol>
        </CRow>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deferred, Head } from '@inertiajs/vue3';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import 'vue3-carousel/carousel.css'

// In your Vue component
const $props: any = defineProps({
    posting: Object,
    status: String
});

/**
 * The configuration object for the carousel.
 *
 * @link https://github.com/ismail9k/vue3-carousel#options
 */
const carouselConfig = {
  /**
   * The number of items to show at once.
   *
   * @type {number}
   */
  itemsToShow: 2.5,
  /**
   * Whether the carousel should wrap around to the start when it reaches the end.
   *
   * @type {boolean}
   */
  wrapAround: true
}

</script>
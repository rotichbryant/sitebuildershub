<template>
    <AuthenticatedLayout>
        <Head title="Postings" />
        <CRow>
            <CCol md="12">
                <h4>View Posting</h4>
                <p>View and manage your posting</p>
            </CCol>
            <CCol md="12">
                <CRow>
                    <CCol md="8" xs="12">
                        <CCol md="12">
                            <h6>List of images</h6>
                        </CCol>
                        <CCard>
                            <CCardBody>
                                <CCol md="12">
                                    <Carousel id="gallery" v-bind="galleryConfig" v-model="currentSlide">
                                        <Slide v-for="(image,index) in $props.posting.images" :key="`image_${index}`">
                                            <img :src="image" alt="Gallery Image" class="gallery-image" />
                                        </Slide>
                                    </Carousel>
                                </CCol>
                                <CCol md="12" class="mt-4" v-if="$props.posting.images.length > 1">
                                    <Carousel  id="thumbnails" v-bind="thumbnailsConfig" v-model="currentSlide">
                                        <Slide v-for="(image,index) in $props.posting.images" :key="`thumbnail_${index}`">
                                            <template #default="{ currentIndex, isActive }">
                                                <div
                                                    :class="['thumbnail', { 'is-active': isActive }]"
                                                    @click="slideTo(currentIndex)"
                                                >
                                                    <img :src="image" alt="Thumbnail Image" class="thumbnail-image" />
                                                </div>
                                            </template>
                                        </Slide>

                                        <template #addons>
                                            <Navigation />
                                            <Pagination />
                                        </template>
                                    </Carousel>
                                </CCol>   
                                <CCol md="12" class="mt-4">
                                    <h4>{{ $props.posting.title }}</h4>
                                    <h6>Tags</h6>
                                    <CBadge color="primary" class="ml-2 p-2" v-for="(tag, index) in $props.posting.categories">{{ tag.sub_category.name }}</CBadge>
                                    <p>{{ $props.posting.description }}</p>
                                </CCol>
                            </CCardBody>
                        </CCard>
                    </CCol>
                    <CCol md="4" xs="12">
                        <h6>Details</h6>
                        <CCard class="mb-4">
                            <CCardHeader class="p-2">Billing</CCardHeader>
                            <CCardBody>
                                <CListGroup>
                                    <CListGroupItem class="d-flex justify-content-between">
                                        <strong>Price:</strong>
                                        {{ $props.posting.price }}
                                    </CListGroupItem>
                                    <CListGroupItem class="d-flex justify-content-between">
                                        <strong>Quantity:</strong> 
                                        {{ $props.posting.quantity }}
                                    </CListGroupItem>
                                    <CListGroupItem class="d-flex justify-content-between">
                                        <strong>Negotiable:</strong> 
                                        {{ $props.posting.negotiable ? 'Yes' : 'No' }}
                                    </CListGroupItem>
                                </CListGroup>
                            </CCardBody>
                        </CCard>
                        <CCard class="mb-4">
                            <CCardHeader class="p-2">Contact</CCardHeader>
                            <CCardBody>
                                <CListGroup>
                                    <CListGroupItem class="d-flex justify-content-between">
                                        <strong>Phone Number:</strong>
                                        {{ $props.posting.phone_number }}
                                    </CListGroupItem>
                                </CListGroup>
                            </CCardBody>
                        </CCard>
                        <CCard class="mb-4">
                            <CCardHeader class="p-2">Location</CCardHeader>
                            <CCardBody>
                                <CListGroup>
                                    <CListGroupItem class="d-flex justify-content-between">
                                        <strong>County:</strong>
                                        {{ $props.posting.county }}
                                    </CListGroupItem>
                                    <CListGroupItem class="d-flex justify-content-between">
                                        <strong>Town:</strong>
                                        {{ $props.posting.town }}
                                    </CListGroupItem>
                                </CListGroup>
                            </CCardBody>
                        </CCard>
                        <CCard class="mb-4">
                            <CCardHeader class="p-2">Created By</CCardHeader>
                            <CCardBody>
                                <CCol md="12" class="d-flex">
                                    <div class="my-auto mx-2">
                                        <CAvatar color="primary" size="lg" class="text-white">
                                            <CIcon name="cil-user" size="xl" />
                                        </CAvatar>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $props.posting.user.name }}</h6>   
                                        <p class="mb-0">{{ $props.posting.user.email }}</p>
                                        <p class="mb-0">{{ $props.posting.user.created_at }}</p>
                                    </div>                             
                                </CCol>
                            </CCardBody>
                        </CCard>
                    </CCol>
                </CRow>
            </CCol>
        </CRow>
    </AuthenticatedLayout>
</template>
<style lang="css">
.carousel {
  --vc-nav-background: rgba(255, 255, 255, 0.7);
  --vc-nav-border-radius: 100%;
}

img {
  border-radius: 8px;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.gallery-image {
  border-radius: 16px;
}

#thumbnails {
  margin-top: 10px;
}

.thumbnail {
  height: 100%;
  width: 100%;
  cursor: pointer;
  opacity: 0.6;
  transition: opacity 0.3s ease-in-out;
}

.thumbnail.is-active,
.thumbnail:hover {
  opacity: 1;
}
</style>
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CCardBody, CFormText } from '@coreui/vue';
import { Deferred, Head } from '@inertiajs/vue3';
import { isNull } from 'lodash';
import { ref } from 'vue';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import 'vue3-carousel/carousel.css'

const currentSlide = ref(0)

const slideTo = (nextSlide: any) => (currentSlide.value = nextSlide)

/**
 * The configuration object for the gallery carousel.
 *
 * @type {Object}
 * @property {Number} itemsToShow - The number of items to show in the carousel.
 * @property {Boolean} wrapAround - Whether to wrap around the carousel when it reaches the end.
 * @property {String} slideEffect - The effect to use when sliding between items.
 * @property {Boolean} mouseDrag - Whether to enable mouse dragging.
 * @property {Boolean} touchDrag - Whether to enable touch dragging.
 * @property {Number} height - The height of the carousel.
 */
const galleryConfig = {
  itemsToShow: 1,
  wrapAround: true,
  slideEffect: 'fade',
  mouseDrag: false,
  touchDrag: false,
  height: 320,
}

/**
 * The configuration object for the thumbnails carousel.
 *
 * @type {Object}
 * @property {Number} height - The height of the carousel.
 * @property {Number} itemsToShow - The number of items to show in the carousel.
 * @property {Boolean} wrapAround - Whether to wrap around the carousel when it reaches the end.
 * @property {Boolean} touchDrag - Whether to enable touch dragging.
 * @property {Number} gap - The gap between items in the carousel.
 */
const thumbnailsConfig = {
  height: 80,
  itemsToShow: 6,
  wrapAround: true,
  touchDrag: false,
  gap: 10,
}


// In your Vue component
const $props: any = defineProps({
    posting: Object,
    status: String
});

/**
 * The configuration object for the carousel.
 *
 * The height of the carousel in pixels.
 *
 * The number of items to show in the carousel.
 *
 * The gap between each item in the carousel in pixels.
 *
 * @link https://github.com/ismail9k/vue3-carousel#options
 */
const carouselConfig = {
    height: 200,
    itemsToShow: 2,
    gap: 5,
}

</script>
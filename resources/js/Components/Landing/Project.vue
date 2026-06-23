<template>
    <div class="col-lg-4 col-md-6" data-aos="fade-up" :data-aos-duration="props.delay" data-aos-once="true">
        <a :href="route('landing.projects.view', { title: decodeURIComponent(project.title) })">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <div class="col-12 px-0">
                        <Swiper 
                            slidesPerView="auto" 
                            :spaceBetween="30" 
                            :modules="$data.modules" 
                            :loop="true" 
                            :pagination="{clickable: true}"
                            :centeredSlides="true"
                            :autoplay="{delay: 2500 + (100 * props.delay),disableOnInteraction: false}"                
                        >
                            <SwiperSlide v-for="(image,index) in project.files" :key="index">
                                <img :src="image" width="100%" height="50%" />
                            </SwiperSlide>
                        </Swiper>      
                        <div class="row">
                            <div class="col-12 my-3">
                                <h5>{{ project.title }}</h5>
                            </div>
                            <div class="col-12 d-flex justify-content-between my-3">
                                <div>
                                    <h6>Start Date</h6>
                                    <p>{{ project.start_date }}</p>
                                </div>
                                <div>
                                    <h6>End Date</h6>
                                    <p>{{ project.end_date }}</p>
                                </div>
                            </div>  
                            <div class="col-12">
                                <h6 class="text-primary"><i class="fa fa-user mr-2"></i> {{ project.user.name }}</h6>
                                <h6 class="text-primary"><i class="fa fa-phone mr-2"></i> {{ project.user.phone_number }}</h6>
                            </div>                          
                        </div>                                                        
                    </div>
                </div>
            </div>   
        </a>     
    </div>
</template>
<script lang="ts" setup>
import { computed, reactive } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

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

const $data = reactive({
    modules: [Autoplay, Pagination, Navigation],
})

const project: any = computed( () => props.data );

</script>
<template>
    <div class="col-12">
        <h4>Project Details</h4>
        <div class="row">
            <div class="col-12 text-right mb-4 px-0">
                <button class="btn btn-primary" @click="$data.modals.create = true">Add Project</button>                            
            </div>                    
            <div class="col-12 py-4 px-0">
                <div class="row" v-if="!isEmpty(pageProps.projects.data)">                        
                    <div class="col-md-6" v-for="(project, index) in pageProps.projects.data">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <div class="col-12 px-0">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-between mb-3">
                                            <h5 class="mb-4">{{ project.title }}</h5> 
                                            <a href="#" class="text-danger" @click.prevent="$delete(project)"><i class="fa fa-trash"></i></a>
                                        </div>
                                        <div class="col-12">
                                            <Swiper 
                                                slidesPerView="auto" 
                                                :spaceBetween="30" 
                                                :modules="$data.modules" 
                                                :loop="true" 
                                                :pagination="{clickable: true}"
                                                :centeredSlides="true"
                                                :autoplay="{delay: 2500,disableOnInteraction: false}"                
                                            >
                                                <SwiperSlide v-for="(image,index) in project.files" :key="index">
                                                    <img :src="image" width="100%" height="70%"/>
                                                </SwiperSlide>
                                            </Swiper>                                               
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
                                        <div class="col-md-12">
                                            <div v-html="project.content"></div>
                                        </div>    
                                    </div>                                                        
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-8" v-if="!isEmpty(pageProps.projects.data)" >
                        <div class="col-md-12 d-flex justify-content-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li 
                                        class="page-item" 
                                        v-bind:class="{ 'disabled': page.url == null, 'active': page.active }" 
                                        v-for="(page,key) in pageProps.projects.links" 
                                        :key="key"
                                    >
                                        <a 
                                            class="page-link" 
                                            :href="page.url"                             
                                            v-html="page.label"
                                        ></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>                                            
                    </div>                    
                </div>
                <div  v-if="isEmpty(pageProps.projects.data)"  class="col-12 d-flex align-items-center justify-content-center" style="height: 50vh;" >
                    <h6 class="text-primary">
                        <i class="fa fa-exclamation-circle mr-2"></i>
                        <span>Nothing Found Here</span>
                    </h6>
                </div>                      
            </div>
        </div>
        <CreateProject 
            :modal.sync="$data.modals.create"
        />
    </div>   
</template>

<script lang="ts" setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { cloneDeep, has, intersection, intersectionBy, isEmpty, keys, map, set } from 'lodash';
import { computed, inject, onMounted, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Multiselect from 'vue-multiselect';
import { VueTelInput } from 'vue3-tel-input';
import 'vue3-tel-input/dist/vue3-tel-input.css';
import { CreateProject } from '../Modals';
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
// import required modules
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import { router } from '@inertiajs/vue3';

const pageProps: any = computed( () => usePage().props );

const $swal: any  = inject('$swal');  
const $toast: any = inject('$toast');  

const $data: any  = reactive({ 
  errors: Object(), 
  modals: {
    create: false
  },
  projects: [], 
  form: {
    first_name:   String(),
    last_name:    String(),
    email:        String(),
    town:         String(),
    phone_number: String(),
  }, 
  modules: [Autoplay, Pagination, Navigation],
});

const $delete = async (project: any) => {

    // Show a confirmation dialog to the user
    const { isConfirmed } = await $swal.fire({
        icon:  'question', // Icon to display in the dialog
        title: 'Delete Posting', // Title of the dialog
        text:  `Are you sure you want to delete ${project.title}?`, // Text content of the dialog
        showCancelButton: true // Whether to show a "Cancel" button
    });

        // If the user does not confirm, exit the function
    if (!isConfirmed) { return; }

    // Fetch the categories from the server
    router.delete(
        route('landing.profile.project.delete',{ project: project.id }),
        {
            onSuccess: () => {
                // Post message
                $toast.success(pageProps.flash.message);   
            },
            onError: (error) => {
                // Set the loading flag
                $data.loaders.fetch = false;
            }
        }
    );
}

onMounted(
    () => {
        console.log(pageProps.projects);
        $data.projects = cloneDeep(pageProps.projects);
    }
)

watch(
  () => pageProps.errors,
  (value:any) => {
    $data.errors = value;
  },
  { deep: true },
)

</script>
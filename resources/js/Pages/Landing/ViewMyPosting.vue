<template>
    <LandingLayout>
        <Head title="View Posting" />
        <template #breadcrumb>
            <ul class="crumb">
                <li><h4>Home</h4></li>
                <li><h4><a :href="route('landing.mypostings')">My Postings</a></h4></li>
                <li><h4><a :href="route('landing.mypostings.show',{ posting: posting.id })">{{ posting.title }}</a></h4></li>
            </ul>
        </template>
        <!-- Main Content Start -->
        <div class="bg-default-2 py-10">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-10 mx-auto">
                        <!-- back Button End -->
                        <div class="row justify-content-center">
                            <div class="col-xxl-8 col-xl-9 col-lg-10">
                                <div class="mb-9">
                                    <a class="d-flex align-items-center ml-4" :href="route('landing.mypostings')"> 
                                        <i class="fa fa-chevron-left bg-white circle-40 mr-5 text-black font-weight-bold shadow-8"></i>
                                        <span class="text-uppercase font-size-3 font-weight-bold text-gray">Back</span>
                                    </a>
                                </div>                                
                                <div class="bg-white px-9 pt-9 pb-7 shadow-8 rounded-4 mb-12">
                                    <div class="px-0 col-12 mb-4">
                                        <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Title</label>
                                        <input type="text" class="form-control" placeholder="Title" v-model="$data.form.title">
                                    </div>
                                    <div class="col-12 px-0 mb-4">
                                        <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Whatsapp Number</label>
                                        <input type="text" class="form-control" placeholder="Phone Number" v-model="$data.form.phone_number">
                                    </div>                                       
                                    <div class="col-12 px-0 mb-4">
                                        <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Categories</label>
                                        <Multiselect 
                                            :group-select="true"
                                            group-values="sub_categories" 
                                            group-label="name"
                                            :options="categories"
                                            :multiple="true"
                                            track-by="name" 
                                            label="name"
                                            v-model="$data.form.categories"
                                        />                                                    
                                    </div>  
                                    <div class="col-12 px-0 mb-4">
                                        <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Description</label>
                                        <textarea type="text" class="form-control" placeholder="Description" rows="10" v-model="$data.form.description"></textarea>
                                    </div>             
                                    <div class="col-12 px-0 mb-4">
                                        <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Images</label>
                                        <vue-dropzone
                                            ref="images" 
                                            id="images" 
                                            :options="$data.photo_options"
                                            @vdropzone-sending="addExtraFormData"
                                            @vdropzone-success="successFileUpload"
                                            @vdropzone-removed-file="handleFileRemoval"
                                        />    
                                    </div>
                                    <div class="col-12 px-0 mb-4">
                                        <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Catalogue</label>
                                        <vue-dropzone
                                            ref="catalogue" 
                                            id="catalogue" 
                                            :options="$data.catalogue_options"
                                            @vdropzone-sending="addExtraFormData"
                                            @vdropzone-success="successCatalogueUpload"
                                            @vdropzone-removed-file="handleCatalogueRemoval"
                                        />    
                                    </div>                                                                                                                              
                                </div>
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-primary text-uppercase h-px-48" @click="submit" >Save Changes</button>
                                </div>
                            </div>
                            <!-- Middle Content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content end -->
    </LandingLayout>
</template>
<script lang="ts" setup>
import axios from 'axios';
import { LandingLayout } from '@/Layouts'
import { Head, useForm, usePage } from '@inertiajs/vue3';
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import { has, isEmpty, map, pick } from 'lodash';
import InnerImageZoom from 'vue-inner-image-zoom';
// import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import { computed, onMounted, reactive, useTemplateRef } from 'vue';
import Multiselect from 'vue-multiselect'
import vueDropzone from 'dropzone-vue3';
import { toast } from 'vue3-toastify';

const posting: any = usePage().props.posting;

const $data: any   = reactive({
    form: {},
    photo_options: {
        addRemoveLinks: true,
        paramName:      'image',
        url:            route('landing.mypostings.image.upload'),
        method:         'post',
        acceptedFiles:  'image/*',
        // headers:        {'Content-Type': 'multipart/form-data'}
    },  
    catalogue_options: {
        addRemoveLinks: true,
        paramName:      'quotation',
        url:            route('landing.mypostings.quotation.upload'),
        method:         'post',
        acceptedFiles:  'application/pdf',
        // headers:        {'Content-Type': 'multipart/form-data'}
        uploadMultiple: false,
    },        
    slider: {
        current: 0,
    }
});

const categories: any = computed( () => usePage().props.categories );

const locations: any  = computed( () => usePage().props.locations );

const pageProps:  any = computed( () => usePage().props );

const addExtraFormData = (file: any,xhr: any, formData: any) => {
    formData.append('_token', pageProps.value.csrf_token);
}

const successFileUpload = (_: any, { name }: any) => {
    // Add the file name to the images array
    $data.form.images.push(name);
}

const successCatalogueUpload = (_: any, { name }: any) => {
    // Add the file name to the images array
    $data.form.quotation = name;
}

const handleFileRemoval = (file: any) => {
    if( has(file,'url') ){
        const urlSplit = file.url.split('/');
        
        useForm({
            _token: pageProps.value.csrf_token,
            filename: urlSplit[urlSplit.length - 1]
        }).put(
            route('landing.mypostings.image.remove',{ posting: posting.id }), 
            {
                onSuccess: ({ props}: any) => {
                    console.log(props);
                },
            }
        ); 
    }
}

/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
const submit = async () => {
    const form    = { 
        ...$data.form, 
        _token: pageProps.value.csrf_token
    };

    useForm(form).put(
        route('landing.mypostings.update',{ posting: posting.id }), 
        {
            onSuccess: ({ props}: any) => {
                toast.success(props.flash.message);
            },

            onError: (value: any) => {
                toast.error(map(value,(message)=>message).join(','));
            }
        }
    );        
};


const handleCatalogueRemoval = (file: any) => {

    if( has(file,'url') ){
        const urlSplit = file.url.split('/');
        
        useForm({
            _token: pageProps.value.csrf_token,
            filename: urlSplit[urlSplit.length - 1]
        }).put(
            route('landing.mypostings.quotation.remove',{ posting: posting.id }), 
            {

                onSuccess: ({ props}: any) => {
                    console.log(props);
                },
            }
        ); 
    }

}

const checkImageMetadata = async (url:string) => {
  try {
    const response = await axios.head(url);
    
    const mimeType = response.headers['content-type'];
    const sizeInBytes = parseInt(response.headers['content-length'], 10);
    
    return { mimeType, sizeInBytes };

  } catch (error) {
    console.error('Failed to read headers', error);
  }
}

const addFiles = async() => {
            
        const imagesInstance: any = useTemplateRef('images')

        if( !isEmpty($data.form.quotation) ){

            const catalogueInstance: any = useTemplateRef('catalogue')        
            const catalogueMeta: any     = await checkImageMetadata($data.form.quotation_link);
            
            if( !isEmpty(catalogueMeta) ){
                const mockCatalogue = { 
                    url:  $data.form.quotation,
                    name: `Catalogue`, 
                    size: catalogueMeta.sizeInBytes, 
                    type: catalogueMeta.mimeType, 
                    isServerImage: true
                };   
                
                catalogueInstance.value.manuallyAddFile(mockCatalogue, $data.form.quotation_link);
                catalogueInstance.value.dropzone.emit('complete', mockCatalogue);    
            }            
            
        }     
        
        console.log($data.form.link_images);
        
        $data.form.link_images.forEach(
            async (image: string, key: number) => {

                const imageMeta: any = await checkImageMetadata(image);
                const mockFile = { 
                    url:  image,
                    name: `Image ${key + 1}`, 
                    size: imageMeta.sizeInBytes, 
                    type: imageMeta.mimeType, 
                    isServerImage: true
                };

                imagesInstance.value.manuallyAddFile(mockFile, image);
                imagesInstance.value.dropzone.emit('thumbnail', mockFile, image);                
                imagesInstance.value.dropzone.emit('complete', mockFile);     

            }
        )

}

onMounted(
    () => {
        $data.form            = pick(usePage().props.posting ,['title','description','categories','images','link_images','quotation_link','location','phone_number','quotation'])
        $data.form.categories = $data.form.categories.map( (value: any) => value.sub_category )
        addFiles();
    }
)
</script>
<template>
    <LandingLayout>
        <Head title="Create Posting" />
        <template #breadcrumb>
            <ul class="crumb">
                <li><h4><a :href="route('landing.home')">Home</a></h4></li>
                <li><h4><a :href="route('landing.mypostings.create')">Create Posting</a></h4></li>
            </ul>
        </template>          
        <div class="container py-10">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-xl-9 col-lg-10">
                    <h2 class="font-size-7 text-center">Post Advert</h2>
                    <div class="bg-white px-9 pt-9 pb-7 shadow-8 rounded-4 mb-12">
                        <form action="/">
                                <div class="tab-content" id="myTabContent">
                                    <Transition name="slide-fade">
                                        <div class="tab-pane fade show active" v-if="$data.tab == 1" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Location</label>
                                                    <select class="form-control w-100" v-model="$data.active_form.location">
                                                        <option value="">Select Location*</option>
                                                        <template v-for="(towns,key) in locations">
                                                            <optgroup :label="key">
                                                                <option v-for="(town) in towns" :value="`${key}-${town}`">{{ town }}</option>
                                                            </optgroup>
                                                        </template>                                                                                    
                                                    </select>
                                                    <p v-show="has($data.errors,'location')" class="text-danger">{{ $data.errors.location }}</p>              
                                                </div>                                
                                                <div class="col-12">
                                                    <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Category</label>
                                                    <select class="form-control w-100" v-model="$data.active_form.category">
                                                        <option value="">Select Category*</option>
                                                        <template v-for="(category,key) in categories">
                                                            <optgroup :label="category.name">
                                                                <option v-for="(sub_category) in category.sub_categories" :value="`${category.id}/${sub_category.id}`">{{ sub_category.name }}</option>
                                                            </optgroup>
                                                        </template>   
                                                    </select>
                                                    <p v-show="has($data.errors,'category')" class="text-danger">{{ $data.errors.category }}</p>              
                                                </div>
                                                <div class="col-12">
                                                    <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Add Photo</label>
                                                    <vue-dropzone
                                                        ref="images" 
                                                        id="images" 
                                                        :options="$data.logo_options"
                                                        @vdropzone-sending="addExtraFormData"
                                                        @vdropzone-success="successFileUpload"
                                                    />    
                                                    <p v-show="has($data.errors,'images')" class="text-danger">{{ $data.errors.images }}</p>              
                                                </div>
                                            </div>
                                        </div>
                                    </Transition>
                                    <Transition name="slide-fade">
                                        <div class="tab-pane fade show active" v-if="$data.tab == 2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="row">
                                                <div class="col-md-6 col-xs-12">
                                                    <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Title</label>
                                                    <input type="text" class="form-control" placeholder="Title" v-model="$data.active_form.title">
                                                    <p v-show="has($data.errors,'title')" class="text-danger">{{ $data.errors.title }}</p>              
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Phone Number</label>
                                                    <input type="text" class="form-control" placeholder="Phone Number" v-model="$data.active_form.phone_number">
                                                    <p v-show="has($data.errors,'phone_number')" class="text-danger">{{ $data.errors.phone_number }}</p>              
                                                </div>
                                                <div class="col-12">
                                                    <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Description</label>
                                                    <textarea type="text" class="form-control" placeholder="Description" rows="10" v-model="$data.active_form.description"></textarea>
                                                    <p v-show="has($data.errors,'description')" class="text-danger">{{ $data.errors.description }}</p>              
                                                </div>
                                            </div>
                                        </div>
                                    </Transition>
                                    <Transition name="slide-fade">
                                        <div class="tab-pane fade show active" v-if="$data.tab == 3" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                            <div class="row">
                                                <div class="col-md-6 col-xs-12">
                                                    <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Quantity</label>
                                                    <input type="number" min="1" class="form-control" placeholder="Quantity" v-model="$data.active_form.quantity">
                                                    <p v-show="has($data.errors,'quantity')" class="text-danger">{{ $data.errors.quantity }}</p>              
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Price</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text p-2 bg-success text-white">Kshs</span>
                                                        </div> 
                                                        <input type="number" min="1" class="form-control" placeholder="Phone Number" v-model="$data.active_form.price">
                                                    </div>
                                                    <p v-show="has($data.errors,'price')" class="text-danger">{{ $data.errors.price }}</p>              
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Are you open to negotiate ?</label>
                                                    <div class="btn-group col-12 px-0">
                                                        <button 
                                                            type="button"
                                                            :class="`btn btn-primary btn-variants-outline ${$data.active_form.negotiate == 'yes' ? 'active' : ''}`"
                                                            @click="$data.active_form.negotiate = 'yes'"
                                                        >
                                                            Yes
                                                        </button>
                                                        <button 
                                                            type="button"
                                                            :class="`btn btn-primary btn-variant-outline ${$data.active_form.negotiate == 'no' ? 'active' : ''}`"
                                                            @click="$data.active_form.negotiate = 'no'"
                                                        >
                                                            No
                                                        </button>
                                                        <button 
                                                            type="button"
                                                            :class="`btn btn-primary btn-variant-outline ${$data.active_form.negotiate == 'notsure' ? 'active' : ''}`"
                                                            @click="$data.active_form.negotiate = 'notsure'"
                                                        >
                                                            Not Sure
                                                        </button>
                                                    </div>  
                                                    <p v-show="has($data.errors,'negotiate')" class="text-danger">{{ $data.errors.negotiate }}</p>              
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Promote Advert</label>
                                                    <div class="btn-group col-12 px-0">
                                                        <button 
                                                            type="button"
                                                            :class="`btn btn-primary btn-variants-outline ${$data.active_form.promotion_status ? 'active' : ''}`"
                                                            @click="$data.active_form.promotion_status = true"
                                                        >
                                                            Yes
                                                        </button>
                                                        <button 
                                                            type="button"
                                                            :class="`btn btn-primary btn-variant-outline ${!$data.active_form.promotion_status ? 'active' : ''}`"
                                                            @click="$data.active_form.promotion_status = false"
                                                        >
                                                            No
                                                        </button>
                                                    </div>  
                                                    <p v-show="has($data.errors,'promote.status')" class="text-danger">{{ $data.active_form.promotion_status }}</p>             
                                                </div> 
                                                <div class="col-12" v-if="$data.active_form.promotion_status">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Placement Section</label>
                                                            <select class="form-control w-100" @change="select_section" :value="$data.active_form.promotion_section">
                                                                <option value="">Select Section*</option>
                                                                <option v-for="(item,key) in pageProps.placements" :value="item.section">{{ item.name }}</option> 
                                                            </select>
                                                            <p v-show="has($data.errors,'promotion_section')" class="text-danger">{{ $data.errors.promotion_section }}</p>              
                                                        </div>  
                                                        <div class="col-12">
                                                            <label for="" class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Add Photo</label>
                                                            <vue-dropzone
                                                                ref="images" 
                                                                id="images" 
                                                                :options="$data.image_options"
                                                                @vdropzone-sending="addExtraFormData"
                                                                @vdropzone-success="successPromotionImageUpload"
                                                            />    
                                                            <p v-show="has($data.errors,'images')" class="text-danger">{{ $data.errors.images }}</p>              
                                                        </div>                                                        
                                                        <div class="col-12 mb-2"> 
                                                            <div class="row">  
                                                                <div class="col-6">
                                                                    <label class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Date From</label>
                                                                    <input type="date" :min="moment().format('YYYY-MM-DD')" class="form-control" placeholder="Date From" v-model="$data.active_form.promotion_date_from">
                                                                    <p v-show="has($data.errors,'promotion_date_from')" class="text-danger">{{ $data.errors.promotion_date_from }}</p>              
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Date To</label>
                                                                    <input type="date" :min="moment().format('YYYY-MM-DD')" class="form-control" placeholder="Date To" v-model="$data.active_form.promotion_date_to">
                                                                    <p v-show="has($data.errors,'promotion_date_to')" class="text-danger">{{ $data.errors.promotion_date_to }}</p>              
                                                                </div>  
                                                            </div>
                                                        </div> 
                                                        <div class="col-12">
                                                            <label class="font-size-4 font-weight-semibold text-black-2 mb-5 line-height-reset">Amount</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text p-2 bg-success text-white">Kshs</span>
                                                                </div>                                                            
                                                                <input type="number" class="form-control" placeholder="Cost" v-model="$data.active_form.promotion_amount">
                                                            </div>
                                                            <p v-show="has($data.errors,'promotion_amount')" class="text-danger">{{ $data.errors.promotion_amount }}</p>              
                                                        </div>                                                                                                              
                                                    </div>                                                     
                                                </div>                                               
                                            </div>
                                        </div>
                                    </Transition>
                                </div>
                            <div class="col-lg-12 mt-4 px-0 d-flex justify-content-between">
                                <button type="button" class="btn btn-primary text-uppercase h-px-48" v-if="$data.tab != 1 && $data.tab <= 3" @click="$data.tab--">Back</button>
                                <button type="button" class="btn btn-primary text-uppercase h-px-48" v-if="$data.tab < 3"  @click="nextTab" :disabled="$data.isDisabled">Next</button>
                                <button type="button" class="btn btn-primary text-uppercase h-px-48" v-if="$data.tab == 3" @click="submit" :disabled="$data.isDisabled">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
    </LandingLayout>    
</template>
<style lang="css">
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.5s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, reactive, watch } from 'vue';
import vueDropzone from 'dropzone-vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { object, string, number, date, InferType, array, boolean, ref } from 'yup';
import { isEmpty, has, cloneDeep, each, flatten, keys, set, flattenDeep, flattenDepth } from 'lodash';
import moment from 'moment';
import { data } from 'jquery';

const $data: any  = reactive({
    active_form:   {},
    active_schema: {},
    logo_options: {
        paramName:      'image',
        url:            route('landing.mypostings.upload'),
        method:         'post',
        thumbnailWidth: 150,
        maxFilesize:    10.0,
    },
    image_options: {
        paramName:       'image',
        url:             route('landing.mypostings.upload'),
        method:          'post',
        thumbnailHeight: 480,
        thumbnailWidth:  640,
        resizeWidth:     640,
        resizeHeight:    480,
        maxFilesize:     10.0,
    },
    errors: {},
    form:   {},
    tab_forms: [
        {
            category:     String(),
            location:     String(),     
            images:       Array(),
        },
        {
            title:        String(),
            description:  String(),
            phone_number: String()
        },
        {
            quantity:               Number(),
            price:                  Number(),
            negotiate:              String('notsure'),
            promotion_amount:       Number(),
            promotion_status:       Boolean(),
            promotion_section:      String(),
            promotion_date_from:    moment().format('YYYY-MM-DD'),
            promotion_date_to:      moment().add(1,'days').format('YYYY-MM-DD'),
        }
    ],
    schemas: [
        {
            category:     string().required("*Category is required"),
            location:     string().required("*Location is required"),
            images:       array().min(1,'*Please select at least one image').required("*Please select at least one image"),
        },
        {
            title:        string().required("*Title is required"),
            description:  string().required("*Description is required"),
            phone_number: string().required("*Phone Number is required"),
        },
        {
            negotiate:      string().required("*Negotiate is required"),
            quantity:       number().min(1).required("*Quantity is required"),     
            price:          number().min(1).required("*Price is required"),
            promotion_amount: number().when("promotion_status",{
                is:   true,
                then: (schema) => schema.min(1, "*Promotion Cost cannot be 0" ).required("*Promotion Cost is required"),
                otherwise: (schema) => schema.nullable()
            }),
            promotion_image: string().when("promotion_status",{
                is:        true,
                then:      (schema)      => schema.required("*Promotion Image is required"),
                otherwise: (schema) => schema.nullable()
            }),            
            promotion_date_from: string().when("promotion_status",{
                is:        true,
                then:      (schema) => schema.matches(/^\d{4}-\d{2}-\d{2}$/,'Promotion date from invalid').required("*Promotion Date From is required"),
                otherwise: (schema) => schema.nullable()
            }),
            promotion_date_to:   string().when("promotion_status",{
                is:        true,
                then:      (schema) => schema.matches(/^\d{4}-\d{2}-\d{2}$/,'Promotion date to invalid').required("*Promotion Date To is required"),
                otherwise: (schema) => schema.nullable()
            }),                                            
            promotion_section:   string().when("promotion_status",{
                is:        true,
                then:      (schema)      => schema.required("*Promotion Section is required"),
                otherwise: (schema) => schema.nullable()
            }),
            promotion_status:    boolean().required("*Promotion Status is required")  
        }
    ],
    tab: 1,
});

const formSchema: any = computed( () => object().shape($data.active_schema) );

/**
 * Validates a form field based on the provided field name.
 * Uses the formSchema to validate the field and updates the errors object accordingly.
 * Updates the isDisabled property based on the presence of errors.
 *
 * @param {string} field - The name of the field to validate.
 */
const validateForm = async (field:string) => {
    try {
        // Validate the field using the formSchema
        await formSchema.value.validateAt(field, $data.active_form);
		delete $data.errors[field];
    } catch(error: any) {
        // If the field is invalid, update the errors object with the error message
        $data.errors[error.path] = error.message;
    } finally {
        // Update the isDisabled property based on the presence of errors
        $data.isDisabled = !isEmpty($data.errors);
    }
}

const categories: any = computed( () => usePage().props.categories );

const locations: any  = computed( () => usePage().props.locations );

const pageProps:  any = computed( () => usePage().props );

const addExtraFormData = (file: any,xhr: any, formData: any) => {
    formData.append('_token', pageProps.value.csrf_token);
}

/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
const submit = async () => {
    const section = pageProps.value.placements.find( (item:any) => item.section == $data.active_form.promotion_section );

    const form    = { 
        ...$data.form, 
        ...$data.active_form,
        _token: pageProps.value.csrf_token
    };

    if( !isEmpty(section) ){
        form['placement_id'] = section.id
    }

    useForm(form).post(
        route('landing.mypostings.store'), 
        {
            onSuccess: ({ props}: any) => {
                if( !form.promotion_status ){
                    if( !isEmpty(props.flash.message) ){
                        toast.success(props.flash.message);
                    }
                    resetForm();                    
                }

                if( form.promotion_status ){
                    create_transaction(props.data)
                }
            },
        }
    );        
};

const create_transaction = async (promotion: any) => {
    router.put(
        route('landing.transactions.promotion.create',{ promotion: promotion.id }),
        {},
        {
            onSuccess: ({ props: { data: { order } } }: any) => {
                window.location.href = order.redirect_url;
            }
        }
    );
}

const calculate_promotion_cost = (value: any) => {
    const section = pageProps.value.placements.find( (item: any) => item.section == value );
    const days    = moment($data.active_form.promotion_date_to).diff(moment($data.active_form.promotion_date_from),'days');

    $data.active_form.promotion_section = value;
    $data.active_form.promotion_amount  = (section.price * days);
}

const select_section = ($event:any) => {

    $data.active_form.promotion_date_from = moment().format('YYYY-MM-DD');
    $data.active_form.promotion_date_to   = moment().add(1,'days').format('YYYY-MM-DD');

    const value   = $event.target.value;
    const section = pageProps.value.placements.find( (item: any) => item.section == value );
    const days    = moment($data.active_form.promotion_date_to).diff(moment($data.active_form.promotion_date_from),'days');

    $data.image_options.thumbnailHeight = section.custom.height;
    $data.image_options.resizeHeight    = section.custom.height;
    $data.image_options.thumbnailWidth  = section.custom.width;
    $data.image_options.resizeWidth     = section.custom.width;

    $data.active_form.promotion_section = value;
    $data.active_form.promotion_amount  = (section.price * days);
}

/**
 * Called when a file is successfully uploaded.
 * 
 * @param {Object} _ - The file object.
 * @param {Object} { name } - The file name.
 */
const successFileUpload = (_: any, { name }: any) => {
    // Add the file name to the images array
    $data.active_form.images.push(name);
}

/**
 * Called when a file is successfully uploaded.
 * 
 * @param {Object} _ - The file object.
 * @param {Object} { name } - The file name.
 */
const successPromotionImageUpload = (_: any, { name }: any) => {
    // Add the file name to the images array
    $data.active_form.promotion_image = name;
}

const nextTab = () => {
    $data.form = { ...$data.form, ...$data.active_form };
    $data.tab++;
}

/**
 * Resets the form data.
 *
 * Resets the email and password fields and clears the error state.
 */
const resetForm = () => {
    // Clear the error state
    $data.errors        = cloneDeep({});
    $data.active_form   = cloneDeep({});
    $data.active_schema = cloneDeep({});
    $data.form          = cloneDeep({});

    $data.tab_forms = [
        {
            category:     String(),
            location:     String(),     
            images:       Array(),
        },
        {
            title:        String(),
            description:  String(),
            phone_number: String()
        },
        {
            quantity:            Number(),
            price:               Number(),
            negotiate:           String('notsure'),
            promotion_image:     String(),
            promotion_amount:    Number(),
            promotion_status:    Boolean(),
            promotion_section:   String(),
            promotion_date_from: moment().format('YYYY-MM-DD'),
            promotion_date_to:   moment().add(1,'days').format('YYYY-MM-DD'),
        }
    ]

    $data.tab           = 1;
}

/**
 * Watches for changes in the form data.
 *
 * Iterates over each field in the form and validates it using the validateForm function.
 * The watch is set to deep to ensure nested properties are observed.
 */
watch(
  () => $data.tab, 
  (tab) => {
    // Iterate over each field in the form and validate it
    $data.active_schema = $data.schemas[tab-1];
    $data.active_form   = $data.tab_forms[tab-1];
    $data.errors        = Object()
  },
  {
    immediate: true
  }
);

/**
 * Watches for changes in the form data.
 *
 * Iterates over each field in the form and validates it using the validateForm function.
 * The watch is set to deep to ensure nested properties are observed.
 */
 watch(
  () => $data.active_form, 
  (form) => {

    // Check on promotion form
    if( 
        !isEmpty(form.promotion_section) && 
        !isEmpty(form.promotion_date_from) &&
        !isEmpty(form.promotion_date_to)
    ){
        calculate_promotion_cost(form.promotion_section);
    }

    // Iterate over each field in the form and validate it
    each(
      form,
      (value, key) => {
        validateForm(key); // Validate the individual form field
      }
    );
  },
  { 
    deep: true, // Set to true to observe nested properties
    immediate: true
  }
);
</script>
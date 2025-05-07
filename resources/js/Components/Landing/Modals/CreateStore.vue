<template>
    <div class="modal fade" tabindex="-1"  id="create-delivery">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Store</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="modal = false"><i class="fa fa-x"></i></button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Store Name</label>
                                <input type="text" :class="`form-control ${has($data.errors,'name') ? 'border-danger' : '' }`" placeholder="eg Drill" id="name" v-model="$data.form.name" :invalid="has($data.errors,'name')" autocomplete="off">
                                <p v-if="has($data.errors,'name')" class="text-danger">{{ $data.errors.name }}</p>              
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Location</label>
                                <select name="category" v-model="$data.form.location" class="form-control">
                                    <options value="">Select Location*</options>
                                    <template v-for="(towns,key) in locations">
                                        <optgroup :label="key">
                                            <option v-for="(town) in towns" :value="`${key}-${town}`">{{ town }}</option>
                                        </optgroup>
                                    </template> 
                                </select>                                
                                <p v-if="has($data.errors,'location')" class="text-danger">{{ $data.errors.location }}</p>              
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="address" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Address</label>
                                <Multiselect 
                                    label="address"
                                    searchable
                                    :options="$data.places"
                                    @search-change="getPlace"
                                    :loading="$data.loaders.places"
                                />
                                <!-- <input type="text" @input="getPlace" :class="`form-control ${has($data.errors,'address') ? 'border-danger' : '' }`" placeholder="Address" id="address" :value="$data.form.address" :invalid="has($data.errors,'address')" autocomplete="off"> -->
                                <p v-if="has($data.errors,'address')" class="text-danger">{{ $data.errors.address }}</p>              
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Tips</label>
                                <input type="text" :class="`form-control ${has($data.errors,'tips') ? 'border-danger' : '' }`" placeholder="Tips on how to find you" id="tips" v-model="$data.form.tips" :invalid="has($data.errors,'tips')" autocomplete="off">
                                <p v-if="has($data.errors,'tips')" class="text-danger">{{ $data.errors.tips }}</p>              
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Business Hours</label>
                                <div class="col-12 p-0 mb-4">
                                    <label>Opened From</label>
                                    <select name="open_from" :class="`form-control ${has($data.errors,'open_from') ? 'border-danger' : '' }`" v-model="$data.form.open_from" class="form-control">
                                        <options value="">From</options>
                                        <option :value="hour" v-for="(hour,key) in $data.hours" :key="`from_${key}`">
                                            {{ hour.time }}
                                        </option>
                                    </select> 
                                    <p v-if="has($data.errors,'open_from')" class="text-danger">{{ $data.errors.open_from }}</p>              
                                </div>
                                <div class="col-12 p-0 mb-4">
                                    <label>Opened To</label>
                                    <select name="open_to" :class="`form-control ${has($data.errors,'open_to') ? 'border-danger' : '' }`" v-model="$data.form.open_to" class="form-control">
                                        <options value="">To</options>
                                        <option :value="hour" v-for="(hour,key) in $data.hours" :key="`from_${key}`" :disabled="hour.id <= ceilHour.id" :class="hour.id <= ceilHour.id ? 'bg-light' : ''">
                                            {{ hour.time }}
                                        </option>
                                    </select>    
                                    <p v-if="has($data.errors,'open_to')" class="text-danger">{{ $data.errors.open_to }}</p>              
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Working Days</label>
                                    <template v-for="(day,key) in $data.days" :key="`day_${key}`">
                                        <button type="button" :class="`mb-2 col-12 btn ${ checkDay(day) ? 'btn-success' : 'btn-outline-success' }`" @click="selectDay(day)">
                                            <!-- <input class="form-check-input" type="checkbox" :id="`day_${key}`" :value="day.id" v-model="$data.form.working_days"> -->
                                            {{ day.name }}
                                        </button>
                                    </template>
                                <p v-if="has($data.errors,'working_days')" class="text-danger">{{ $data.errors.working_days }}</p>              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" @click="modal = false">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>    
</template>
  
<script lang="ts" setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, defineEmits, defineProps, reactive, ref, watch } from 'vue';
import { cloneDeep, debounce, each, isEmpty, has, get } from 'lodash';
import Multiselect from 'vue-multiselect';
import { array, object, string } from 'yup';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const $emit  = defineEmits(['update:modal']);

const $data: any  = reactive({
    days: [
        { id: 1, name: 'Monday' },
        { id: 2, name: 'Tuesday' },
        { id: 3, name: 'Wednesday' },
        { id: 4, name: 'Thursday' },
        { id: 5, name: 'Friday' },
        { id: 6, name: 'Saturday' },
        { id: 7, name: 'Sunday' }
    ],
    form:{
        name:         String(),
        location:     String(), 
        address:      String(),
        tips:         String(),
        open_form:    {},
        open_to:      {},
        working_days: [],
    },
    hours:[
        { id: 1, time: "01:00" },
        { id: 2, time: "02:00" },
        { id: 3, time: "03:00" },
        { id: 4, time: "04:00" },
        { id: 5, time: "05:00" },
        { id: 6, time: "06:00" },
        { id: 7, time: "07:00" },
        { id: 8, time: "08:00" },
        { id: 9, time: "09:00" },
        { id: 10, time: "10:00" },
        { id: 11, time: "11:00" },
        { id: 12, time: "12:00" },
        { id: 13, time: "13:00" },
        { id: 14, time: "14:00" },
        { id: 15, time: "15:00" },
        { id: 16, time: "16:00" },
        { id: 17, time: "17:00" },
        { id: 18, time: "18:00" },
        { id: 19, time: "19:00" },
        { id: 20, time: "20:00" },
        { id: 21, time: "21:00" },
        { id: 22, time: "22:00" },
        { id: 23, time: "23:00" },
        { id: 24, time: "00:00" },
    ],
    loaders: {
        places: false,
    },
    errors: Object(),
    isDisabled: true,  
    places: [],
    schema: {
        name:         string().required("*Name is required"),
        location:     string().required("*Location is required"),
        address:      string().required("*Address is required"),
        tips:         string().required("*Tips is required"),
        open_from:    object().shape({
            id: string().required("*Hour To is required"),
            time: string().required("*Hour To is required"),
        }).required("*Hour From is required").test( '', "*Hour From is required",(val:any) => !isEmpty(val) ),
        open_to:      object().shape({
            id: string().required("*Hour To is required"),
            time: string().required("*Hour To is required"),
        }).required("*Hour To is required").test( '', "*Hour To is required",(val:any) => !isEmpty(val) ),
        working_days: array().min(1,"*Working Days requires at least one day").required("*Working Days is required").test( (val:any) => !isEmpty(val) ),
    },
});

const $props: any = defineProps({
    modal: {
        default: Boolean(),
        type:    Boolean,
    } 
});

const locations        = usePage().props.locations;

const ceilHour:any    = computed( () => !isEmpty($data.form.open_from) ? $data.hours.find( (val: any) => val.time === $data.form.open_from.time ) : {} );

const jQuery: any     = computed( () => get(window,'jQuery') );

const modal: any      = computed({
    get: ()          => $props.modal,
    set: (value:any) => $emit('update:modal', value),
});

const formSchema: any = computed( () => object().shape($data.schema) );

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
        await formSchema.value.validateAt(field, $data.form);
		delete $data.errors[field];
    } catch(error: any) {
        // If the field is invalid, update the errors object with the error message
        $data.errors[error.path] = error.message;
    } finally {
        // Update the isDisabled property based on the presence of errors
        $data.isDisabled = !isEmpty($data.errors);
    }
}

/**
 * Submits the login form.
 *
 * Posts the form data to the `login` route and resets the password field
 * on success.
 */
const submit = () => {
    useForm({
        _token: usePage().props.csrf_token,
        ...$data.form
    }).post(
        route('landing.profile.business.store'), 
        {
            onSuccess: (value: any) => {
                if( !isEmpty(value.props.flash.message) ){
                    toast.success(value.props.flash.message);
                    resetForm();
                }
            },
        }
    );
};

/**
 * Resets the form data.
 *
 * Resets the form fields to their initial state (empty strings and empty arrays).
 */
const resetForm = () => {
    $data.form = {
        // The name of the store
        name:         String(),
        // The location of the store
        location:     String(), 
        // The address of the store
        address:      String(),
        // The tips for the store
        tips:         String(),
        // The hour from which the store is open
        open_from:    String(),
        // The hour at which the store closes
        open_to:      String(),
        // The working days of the store
        working_days: [],
    }
}

/**
 * Checks if the given day is present in the `working_days` array.
 *
 * @param {any} day - The day to be checked in the `working_days` array.
 * @returns {boolean} true if the day is present, false otherwise.
 */
const checkDay = (day: any): boolean => {
    return !isEmpty($data.form.working_days) && $data.form.working_days.find( (val:any) => val.id === day.id ) ?  true : false;
}

const getPlace = debounce (
    async (search_query: string) => {
        console.log(search_query);
        try {
            $data.loaders.places = true;
            const maps     = usePage().props.maps;
            const { data } = await fetch(`${maps.api_url}/json?key=${maps.api_key}&input=${search_query}&inputtype=textquery&fields=${maps.fields}`);
            $data.loaders.places = true;
            console.log(data);
        } catch(error) {
            $data.loaders.places = false;
        } finally {
            $data.loaders.places = false;
        }
    },500
)

/**
 * Toggles the selection of a day.
 *
 * Adds the given day to the `working_days` array if it is not already selected.
 * Removes the day if it is already present in the array.
 *
 * @param {any} day - The day to be toggled in the `working_days` array.
 */

const selectDay = (day: any) => {
    switch( isEmpty($data.form.working_days) ) {
        case true:
            $data.form.working_days.push(day);
        break;
        case false:
            if( $data.form.working_days.find( val => val.id === day.id) == undefined ){
                $data.form.working_days.push(day);          
            } else {
                $data.form.working_days = $data.form.working_days.filter( val => val.id !== day.id );        
            }       
        break;
    }
}

watch(
    () => usePage().props.errors,
    (value:any) => {
        $data.errors = cloneDeep(value);
    },
    { deep: true },
)

/**
 * Watches for changes in the form data.
 *
 * Iterates over each field in the form and validates it using the validateForm function.
 * The watch is set to deep to ensure nested properties are observed.
 */
 watch(
  () => $data.form, 
  (form) => {
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

watch(
    () => $props.modal,
    (show: boolean) => {
        jQuery.value('#create-delivery').modal( show ? { backdrop: 'static', keyboard: false, show, focus: true } : 'hide');
        if( !show ){ resetForm(); }
    },
)
</script>
<template>
    <div class="modal fade" tabindex="-1"  id="create-delivery">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Store</h5>
                <button type="button" class="btn-close d-flex align-items-center mt-3" @click="modal = false"><i class="fas fa-times fa-sm"></i></button>
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
                                <Multiselect 
                                    :group-select="false"
                                    group-values="cities" 
                                    group-label="name"
                                    :options="locations"
                                    :multiple="false"
                                    track-by="name" 
                                    label="name"
                                    @select="selectCity"
                                    :value="$data.selected.city"
                                />                               
                                <p v-if="has($data.errors,'location')" class="text-danger">{{ $data.errors.location }}</p>              
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Tips</label>
                                <textarea rows="5" :class="`form-control ${has($data.errors,'tips') ? 'border-danger' : '' }`" placeholder="Tips on how to find you" id="tips" v-model="$data.form.tips" :invalid="has($data.errors,'tips')" autocomplete="off"></textarea>
                                <p v-if="has($data.errors,'tips')" class="text-danger">{{ $data.errors.tips }}</p>              
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Business Hours</label>
                            <div class="form-group d-flex justify-content-between">
                                <div class="col-md-6 pl-0">
                                    <label>Opened From</label>
                                    <select name="open_from" :class="`form-control ${has($data.errors,'open_from') ? 'border-danger' : '' }`" v-model="$data.form.open_from" class="form-control">
                                        <options value="">From</options>
                                        <option :value="hour" v-for="(hour,key) in $data.hours" :key="`from_${key}`">
                                            {{ hour.time }}
                                        </option>
                                    </select> 
                                    <p v-if="has($data.errors,'open_from')" class="text-danger">{{ $data.errors.open_from }}</p>              
                                </div>
                                <div class="col-md-6 pr-0">
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
                        <div class="col-12">
                            <div class="form-group">
                                <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Working Days</label>
                                <div class="col-12 row">
                                    <template v-for="(day,key) in $data.days" :key="`day_${key}`">
                                        <div class="col-md-6 col-12 px-2">
                                            <button type="button" :class="`mb-2 w-100 btn ${ checkDay(day) ? 'btn-success' : 'btn-outline-success' }`" @click="selectDay(day)">
                                                {{ day.name }}
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <p v-if="has($data.errors,'working_days')" class="text-danger">{{ $data.errors.working_days }}</p>              
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Address</label>
                                <GoogleMap
                                    @click="markerDrag"
                                    :api-key="config_maps.api_key"
                                    :mapId="config_maps.id"
                                    style="width: 100%; height: 250px"
                                    :center="$data.map.center"
                                    :zoom="$data.map.zoom"
                                >
                                    <AdvancedMarker :options="markerOptions" :pin-options="$data.map.pinOptions" />
                                </GoogleMap>                              
                                <!-- <input type="text" @input="getPlace" :class="`form-control ${has($data.errors,'address') ? 'border-danger' : '' }`" placeholder="Address" id="address" :value="$data.form.address" :invalid="has($data.errors,'address')" autocomplete="off"> -->
                                <p v-if="has($data.errors,'address')" class="text-danger">{{ $data.errors.address }}</p>              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" @click="modal = false">Close</button>
                    <button type="submit" class="btn btn-primary" :disabled="$data.isDisabled || $data.loaders.create">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>    
</template>
  
<script lang="ts" setup>
import { useForm, usePage } from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect';
import { computed, defineEmits, defineProps, onMounted, reactive, watch } from 'vue';
import { cloneDeep, each, isEmpty, has, get, map } from 'lodash';
import { array, number, object, string } from 'yup';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const $emit            = defineEmits(['update:modal']);

const config_maps: any = usePage().props.maps;

const $data: any       = reactive({
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
        coords:       {
            lat: 0,
            lng: 0
        },
        tips:         String(),
        open_from:    {},
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
        create: false,
    },
    errors: Object(),
    isDisabled: true,  
    map: {
        center: {
            lat: 0,
            lng: 0
        },
        pinOptions: { 
            background: '#FF0000',
            borderColor: '#000000', // black border
        },
        zoom: 18,
    },
    places: [],
    schema: {
        name:         string().required("*Name is required"),
        location:     string().required("*Location is required"),
        coords:    object().shape({
            lat:  number().required("*Coordinates is required"),
            lng: number().required("*Coordinates is required"),
        }).required("*Hour From is required").test( '', "*Coordinates is required",(val:any) => !isEmpty(val) ),
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
    selected: {
        city: {}
    }
});

const $props: any = defineProps({
    modal: {
        default: Boolean(),
        type:    Boolean,
    } 
});

const markerOptions = computed( 
    () => ({ 
        position: $data.map.center, 
        title:'A',
        gmpDraggable: true,
        gmpClickable: true
    }) 
);

const markerDrag = (event: any) => {
  // Update the map center with the user's location
  $data.map.center = {
    lat: event.latLng.lat(),
    lng: event.latLng.lng()
  };
  // Update the form `coords` with the user's location
  $data.form.coords = {
    lat: event.latLng.lat(),
    lng: event.latLng.lng()
  };    
}

const locations: any = computed( 
    () => map(
        usePage().props.locations,
        (cities: any,key: string) => ({ 
            name: key, 
            cities: cities.map( 
                (city: string) => ({ name: city }) 
            ) 
        })
    )
);

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
                console.log(value);
                if( !isEmpty(value.props.flash.message) ){
                    modal.value = false;
                    toast.success(value.props.flash.message);
                }
            },
            onError: (value: any) => {
                console.log(value);
                // if( !isEmpty(value.props.flash.message) ){
                //     toast.error(value.props.flash.message);
                // }
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
        coords:       {
            lat: 0,
            lng: 0
        },
        // The tips for the store
        tips:         String(),
        // The hour from which the store is open
        open_from:    {},
        // The hour at which the store closes
        open_to:      {},
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

/**
 * Selects a city from the list of locations.
 *
 * Updates the form field `location` with the name of the selected city.
 *
 * @param {Object} location - The selected city from the list of locations.
 */
const selectCity = (location: any): void => {
    $data.selected.city = location;
    $data.form.location = location.name;
}

/**
 * Callback function for when the user grants geolocation permission.
 *
 * @param {Object} position - The geolocation object with the user's current location.
 */
const successCallback = (position: any) => {
  // Update the map center with the user's location
  $data.map.center = {
    lat: position.coords.latitude,
    lng: position.coords.longitude
  };
  // Update the form `coords` with the user's location
  $data.form.coords = {
    lat: position.coords.latitude,
    lng: position.coords.longitude
  };
}

/**
 * The error callback function when the user denies geolocation permission.
 *
 * Prints an error message to the console depending on the error code.
 *
 * @param {Object} error - The error object containing the error code and message.
 */
const errorCallback = (error: any) => {
  switch (error.code) {
    /**
     * The user denied the request for geolocation.
     *
     * Prints "User denied the request for geolocation." to the console.
     */
    case error.PERMISSION_DENIED:
      console.log("User denied the request for geolocation.");
      break;
    /**
     * Location information is unavailable.
     *
     * Prints "Location information is unavailable." to the console.
     */
    case error.POSITION_UNAVAILABLE:
      console.log("Location information is unavailable.");
      break;
    /**
     * The request to get user location timed out.
     *
     * Prints "The request to get user location timed out." to the console.
     */
    case error.TIMEOUT:
      console.log("The request to get user location timed out.");
      break;
    /**
     * An unknown error occurred.
     *
     * Prints "An unknown error occurred." to the console.
     */
    case error.UNKNOWN_ERROR:
      console.log("An unknown error occurred.");
      break;
  }
}

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

/**
 * Requests the user's location and sets it as the store's location.
 *
 * Prints "Geolocation is not supported by this browser." to the console if the browser does not support geolocation.
 */
const locationConsent = () => {
    /**
     * Checks if the browser supports geolocation.
     *
     * If the browser does not support geolocation, it prints "Geolocation is not supported by this browser." to the console.
     */
    if (navigator.geolocation) {
        /**
         * Requests the user's location.
         *
         * Calls successCallback on success and errorCallback on failure.
         */
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    } else {
        console.log("Geolocation is not supported by this browser.");
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
        if( show ){ locationConsent() }
        jQuery.value('#create-delivery').modal( show ? { backdrop: 'static', keyboard: false, show, focus: true } : 'hide');
        if( !show ){ resetForm(); }
    },
)
</script>          

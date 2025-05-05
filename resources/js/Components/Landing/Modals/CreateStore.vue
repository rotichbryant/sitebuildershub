<template>
    <div class="modal fade" tabindex="-1"  id="create-delivery">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Delivery Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="modal = false"></button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Store Name</label>
                                <input type="text" :class="`form-control ${has($data.errors,'name') ? 'border-danger' : '' }`" placeholder="eg Drill" id="name" v-model="$data.form.name" :invalid="has($data.errors,'name')" autocomplete="off">
                                <p v-if="has($data.errors,'name')" class="text-danger">{{ $data.errors.name }}</p>              
                            </div>
                            <div class="form-group">
                                <label for="title" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Location</label>
                                <select name="category" v-model="$data.form.location" class="form-control">
                                    <options value="">Select Location*</options>
                                    <option value="" v-for="category in $data.locations" :key="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>                                
                                <p v-if="has($data.errors,'location')" class="text-danger">{{ $data.errors.location }}</p>              
                            </div>
                            <div class="form-group">
                                <label for="address" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Address</label>
                                <input type="text" :class="`form-control ${has($data.errors,'address') ? 'border-danger' : '' }`" placeholder="Address" id="address" v-model="$data.form.address" :invalid="has($data.errors,'address')" autocomplete="off">
                                <p v-if="has($data.errors,'address')" class="text-danger">{{ $data.errors.address }}</p>              
                            </div>
                            <div class="form-group">
                                <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Tips</label>
                                <input type="text" :class="`form-control ${has($data.errors,'tips') ? 'border-danger' : '' }`" placeholder="Tips on how to find you" id="tips" v-model="$data.form.tips" :invalid="has($data.errors,'tips')" autocomplete="off">
                                <p v-if="has($data.errors,'tips')" class="text-danger">{{ $data.errors.tips }}</p>              
                            </div>
                            <div class="form-group">
                                <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Business Hours</label>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <select name="hour_from" :class="`form-control ${has($data.errors,'hour_from') ? 'border-danger' : '' }`" v-model="$data.form.hour_from" class="form-control">
                                            <options value="">From</options>
                                            <option :value="hour" v-for="(hour,key) in $data.hours" :key="`from_${key}`">
                                                {{ hour.time }}
                                            </option>
                                        </select> 
                                        <p v-if="has($data.errors,'hour_from')" class="text-danger">{{ $data.errors.hour_from }}</p>              
                                    </div>
                                    <div>
                                        <select name="hour_to" :class="`form-control ${has($data.errors,'hour_to') ? 'border-danger' : '' }`" v-model="$data.form.hour_to" class="form-control">
                                            <options value="">From</options>
                                            <option :value="hour" v-for="(hour,key) in $data.hours" :key="`from_${key}`" :disabled="hour.id <= ceilHour.id" :class="hour.id <= ceilHour.id ? 'bg-light' : ''">
                                                {{ hour.time }}
                                            </option>
                                        </select>    
                                        <p v-if="has($data.errors,'hour_to')" class="text-danger">{{ $data.errors.hour_to }}</p>              
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tips" class="font-size-4 text-black-2 font-weight-semibold line-height-reset">Working Days</label>
                                <div class="col-12">
                                    <template v-for="(day,key) in $data.days" :key="`day_${key}`">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" :id="`day_${key}`" :value="day.id" v-model="$data.form.working_days">
                                            <label class="form-check-label" :for="`day_${key}`">
                                                {{ day.name }}
                                            </label>
                                        </div>
                                    </template>
                                </div>
                                <p v-if="has($data.errors,'tips')" class="text-danger">{{ $data.errors.tips }}</p>              
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
import { cloneDeep, each, isEmpty, has, get } from 'lodash';
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
        hour_from:    {},
        hour_to:      {},
        working_days: ref([]),
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
    errors: Object(),
    isDisabled: true,  
    schema: {
        name:         string().required("*Name is required"),
        location:     string().required("*Location is required"),
        address:      string().required("*Address is required"),
        tips:         string().required("*Tips is required"),
        hour_from:    object().required("*Hour From is required").test( (val:any) => !isEmpty(val) ),
        hour_to:      object().required("*Hour To is required").test( (val:any) => !isEmpty(val) ),
        working_days: array().required("*Working Days is required").test( (val:any) => !isEmpty(val) ),
    },
});

const $props: any = defineProps({
    csrf_token: {
        default: String(),
        type:    String,
    },
    modal: {
        default: Boolean(),
        type:    Boolean,
    } 
});

const ceilHour:any = computed( () => !isEmpty($data.form.hour_from) ? $data.hours.find( (val: any) => val.time === $data.form.hour_from.time ) : {} );

const jQuery: any  = computed( () => get(window,'jQuery') );

const modal: any  = computed({
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
        _token: $props.value.csrf_token,
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

const resetForm = () => {
    $data.form = {
        name:         String(),
        location:     String(), 
        address:      String(),
        tips:         String(),
        hour_from:    String(),
        hour_to:      String(),
        working_days: [],
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
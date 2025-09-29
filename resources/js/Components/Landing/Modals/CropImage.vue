<template>
    <div class="modal fade" tabindex="-1"  id="crop-image">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image</h5>
                    <button type="button" class="btn-close d-flex align-items-center mt-3" @click="modal = false"><i class="fas fa-times fa-sm"></i></button>
                </div>
                <CropperCanvas>
                    <CropperImage
                        @transform="onCropperImageTransform"
                    ></CropperImage>
                </CropperCanvas>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { computed, watch } from 'vue';
import type CropperCanvas from '@cropper/element-canvas';
import type CropperImage from '@cropper/element-image';

const $emit        = defineEmits(['update:modal']);

const modal: any   = computed({
    get: ()          => $props.modal,
    set: (value:any) => $emit('update:modal', value),
});

const $props: any  = defineProps({
    modal: {
        default: Boolean(),
        type:    Boolean,
    } 
});

const onCropperImageTransform = (event: any) => {
    console.log(event.detail);
}

watch(
    () =>$props.modal,
    (value) => {
        
    }
)
</script>
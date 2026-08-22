<template>
    <div class="col-12 px-0 py-3">
        <h5>Comments</h5>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="col-12" v-for="(comment,index) in posting.comments" v-if="!isEmpty(posting.comments)">
                    <p class="text-muted">{{ comment.message }}</p>
                    <h6>{{ moment(comment.created_at).format('lll') }} <br> {{ comment.user.name }}</h6>
                    <hr v-if="index != (posting.comments.length - 1)"/>
                </div>
                <div class="col-12 text-center p-0">
                    <p class="mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>Nothing found here</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import moment from 'moment';
import { computed } from 'vue';
import { isEmpty } from 'lodash';

const posting: any = computed( () => usePage().props.posting );

</script>
<template>
    <div class="col-12 px-0 py-3">
        <h5>Comments</h5>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="col-12" v-for="(comment,index) in posting.comments">
                    <p class="text-muted">{{ comment.message }}</p>
                    <h6>{{ moment(comment.created_at).format('lll') }} <br> {{ comment.user.name }}</h6>
                    <hr v-if="index != (posting.comments.length - 1)"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import moment from 'moment';
import { computed } from 'vue';

const posting: any = computed( () => usePage().props.posting );

</script>
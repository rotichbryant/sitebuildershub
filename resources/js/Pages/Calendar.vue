<script setup>
import { reactive } from 'vue';
import { Qalendar } from "qalendar";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const $data = reactive({
    events: [
        {
            title: "Advanced algebra",
            with: "Chandler Bing",
            time: { start: "2025-01-23 12:05", end: "2025-01-23 13:35" },
            color: "yellow",
            isEditable: true,
            id: "753944708f0f",
            description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores assumenda corporis doloremque et expedita molestias necessitatibus quam quas temporibus veritatis. Deserunt excepturi illum nobis perferendis praesentium repudiandae saepe sapiente voluptatem!"
        },
        {
            title: "Ralph on holiday",
            with: "Rachel Greene",
            time: { start: "2025-01-10", end: "2025-01-22" },
            color: "green",
            isEditable: true,
            id: "5602b6f589fc"
        }
    ],
    config: {
        // see configuration section
        defaultMode: "month",
        colorSchemes: {
            meetings: {
                color: "#fff",
                backgroundColor: "#131313",
            },
            sports: {
                color: "#fff",
                backgroundColor: "#ff4081",
            },
        },
    } 
});
</script>
<style>
@import "qalendar/dist/style.css";
</style>
<template>
    <Head title="Calendar" />
    <AuthenticatedLayout>
        <CCard class="mb-4">
            <CCardHeader>
              <strong>Vue Table</strong> <small>Basic example</small>
            </CCardHeader>
            <CCardBody>
                <Qalendar 
                    :events="$data.events"
                    :config="$data.config"
                />
            </CCardBody>
        </CCard>
    </AuthenticatedLayout>
</template>
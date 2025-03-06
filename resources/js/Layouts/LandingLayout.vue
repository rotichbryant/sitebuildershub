<script setup lang="ts">
import { ref } from 'vue';
import { LandingFooter, LandingHeader } from '../Components'
</script>

<template>
    <div class="wrapper d-flex flex-column min-vh-100">
      <LandingHeader />
        <div class="body flex-grow-1">
            <CContainer fluid>
            <slot />
            </CContainer>
        </div>
      <LandingFooter />
    </div>
</template>

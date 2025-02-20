<script setup lang="ts">
import { ref } from 'vue';
import {AppFooter,AppHeader,AppSidebar} from '../Components'
</script>

<template>
  <div>
    <AppSidebar />
    <div class="wrapper d-flex flex-column min-vh-100">
      <AppHeader />
      <div class="body flex-grow-1">
        <CContainer class="px-4" lg>
          <slot />
        </CContainer>
      </div>
    </div>
  </div>
</template>

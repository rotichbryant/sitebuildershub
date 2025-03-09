<template>
  <div>
    <Sidebar />
    <div class="wrapper d-flex flex-column min-vh-100">
      <Header />
      <div class="body flex-grow-1">
        <CContainer class="px-4" lg>
          <slot />
        </CContainer>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import '../../scss/app.scss';
import { ref } from 'vue';
import {Header,Sidebar} from '../Components/Dashboard'
</script>

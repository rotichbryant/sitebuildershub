<script setup>
// import { RouterLink } from 'vue-router'

// import { logo } from '@/assets/brand/logo'
// import { sygnet } from '@/assets/brand/sygnet'
// import { AppSidebarNav } from '@/components/AppSidebarNav.js'
// import { useSidebarStore } from '@/stores/sidebar.js'

// const sidebar = useSidebarStore()
</script>

<template>
<CSidebar position="fixed">
  <CSidebarHeader class="border-bottom">
    <CSidebarBrand>CoreUI</CSidebarBrand>
  </CSidebarHeader>
  <CSidebarNav>
    <CNavItem :href="route('dashboard.overview')">
      <CIcon customClassName="nav-icon" icon="cil-speedometer"/> Overview
    </CNavItem>
    <CNavTitle>Data Management</CNavTitle>
    <CNavItem :href="route('dashboard.clients')">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Clients
    </CNavItem>
    <CNavItem :href="route('dashboard.postings')">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Postings
    </CNavItem>
    <CNavItem :href="route('dashboard.staff')">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Staff
    </CNavItem>
    <CNavItem :href="route('dashboard.subscriptions')">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Subscriptions
    </CNavItem>
    <CNavTitle>Support</CNavTitle>
    <CNavItem :href="route('dashboard.notifications')">
      <CIcon  customClassName="nav-icon" icon="cil-bell"/> Notifications
    </CNavItem>
    <CNavTitle>Settings</CNavTitle>
    <CNavItem :href="route('dashboard.profile')">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Profile
    </CNavItem>
    <CNavItem :href="route('dashboard.company')">
      <CIcon  customClassName="nav-icon" icon="cil-building"/> Company
    </CNavItem>
    <CNavItem :href="route('dashboard.system')">
      <CIcon  customClassName="nav-icon" icon="cil-cogs"/> System
    </CNavItem>
  </CSidebarNav>
  <CSidebarFooter class="border-top">
    <CSidebarToggler/>
  </CSidebarFooter>
</CSidebar>
</template>

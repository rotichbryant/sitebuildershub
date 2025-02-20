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
    <CNavItem href="overview">
      <CIcon customClassName="nav-icon" icon="cil-speedometer"/> Overview
    </CNavItem>
    <CNavTitle>Data Management</CNavTitle>
    <CNavItem href="appointments">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Appointments
    </CNavItem>
    <CNavItem href="calendar">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Calendar
    </CNavItem>
    <CNavItem href="clients">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Clients
    </CNavItem>
    <CNavItem href="staff">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Staff
    </CNavItem>
    <CNavItem href="services">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Services
    </CNavItem>
    <CNavTitle>Messages</CNavTitle>
    <CNavItem href="mail">
      <CIcon  customClassName="nav-icon" icon="cil-envelope"/> Mail
    </CNavItem>
    <CNavItem href="alerts">
      <CIcon  customClassName="nav-icon" icon="cil-bell"/> Alerts
    </CNavItem>
    <CNavTitle>Settings</CNavTitle>
    <CNavItem href="profile">
      <CIcon  customClassName="nav-icon" icon="cil-user"/> Profile
    </CNavItem>
    <CNavItem href="company">
      <CIcon  customClassName="nav-icon" icon="cil-building"/> Company
    </CNavItem>
    <CNavItem href="system">
      <CIcon  customClassName="nav-icon" icon="cil-cogs"/> System
    </CNavItem>
  </CSidebarNav>
  <CSidebarFooter class="border-top">
    <CSidebarToggler/>
  </CSidebarFooter>
</CSidebar>
</template>

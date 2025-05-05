<template>
  <!-- Header Area -->
  <header class="site-header site-header--menu-right bg-default py-7 py-lg-0 site-header--absolute site-header--sticky z-index-1">
    <div class="container">
      <nav class="navbar site-navbar offcanvas-active navbar-expand-lg  px-0 py-0">
        <!-- Brand Logo-->
        <div class="brand-logo">
          <a href="./index.html">
            <!-- light version logo (logo must be black)-->
            <!-- <img src="../../../image/logo-main-black.png" alt="" class="light-version-logo default-logo"> -->
            <!-- Dark version logo (logo must be White)-->
            <!-- <img src="../../../image/logo-main-white.png" alt="" class="dark-version-logo"> -->
          </a>
        </div>
        <div class="collapse navbar-collapse" id="mobile-menu">
          <div class="navbar-nav-wrapper">
            <ul class="navbar-nav main-menu">
              <li class="nav-item">
                <a class="nav-link" :href="route('landing.home')">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" :href="route('landing.postings')">Postings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" :href="route('landing.aboutus')">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" :href="route('landing.contactus')">Contact Us</a>
              </li>
            </ul>
          </div>
          <button class="d-block d-lg-none offcanvas-btn-close focus-reset" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="true" aria-label="Toggle navigation">
            <i class="gr-cross-icon"></i>
          </button>
        </div>
        <div class="header-btns header-btn-devider ml-auto pr-2 ml-lg-6 d-none d-xs-flex" v-if="isEmpty(auth_user)">
          <a class="btn btn-transparent text-uppercase font-size-3 heading-default-color focus-reset" href="#" @click="$data.modals.login = true">
            Log in
          </a>
          <a class="btn btn-primary text-uppercase font-size-3" href="#" @click="$data.modals.signup = true">
            Sign up
          </a>
        </div>
        <div class="header-btn-devider ml-auto ml-lg-5 pl-2 d-none d-xs-flex align-items-center" v-else>
          <div>
            <a href="#" class="px-3 ml-7 font-size-7 notification-block flex-y-center position-relative">
              <i class="fas fa-bell heading-default-color"></i>
              <span class="font-size-3 count font-weight-semibold text-white bg-primary circle-24 border border-width-3 border border-white">3</span>
            </a>
          </div>
          <div>
            <div class="dropdown show-gr-dropdown py-5">
              <a class="proile media ml-7 flex-y-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user fa-lg"></i>                
                <!-- <div class="circle-40">
                </div> -->
                <i class="fas fa-chevron-down heading-default-color ml-6"></i>
              </a>
              <div class="dropdown-menu gr-menu-dropdown dropdown-right border-0 border-width-2 py-2 w-auto bg-default" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item py-2 font-size-3 font-weight-semibold line-height-1p2 text-uppercase" :href="route('landing.overview')">Overview </a>
                <a class="dropdown-item py-2 font-size-3 font-weight-semibold line-height-1p2 text-uppercase" :href="route('landing.mypostings')">My Postings </a>
                <a class="dropdown-item py-2 font-size-3 font-weight-semibold line-height-1p2 text-uppercase" :href="route('landing.chat')">Chat</a>
                <a class="dropdown-item py-2 font-size-3 font-weight-semibold line-height-1p2 text-uppercase" :href="route('landing.profile',{ tab:'personal'})">Profile</a>
                <a class="dropdown-item py-2 text-red font-size-3 font-weight-semibold line-height-1p2 text-uppercase" href="#" @click="logout">Log Out</a>
              </div>
            </div>
          </div>
        </div>
        <!-- Mobile Menu Hamburger-->
        <button class="navbar-toggler btn-close-off-canvas  hamburger-icon border-0" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
          <!-- <i class="icon icon-simple-remove icon-close"></i> -->
          <span class="hamburger hamburger--squeeze js-hamburger">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </span>
        </button>
        <!--/.Mobile Menu Hamburger Ends-->
      </nav>
    </div>
    <Login
      :modals="$data.modals"
      @update:modals="$data.modals = $event"
      v-if="isEmpty(auth_user)"
    />
    <SignUp
      :modals="$data.modals"
      @update:modals="$data.modals = $event"
      v-if="isEmpty(auth_user)"
    />
  </header>
</template>
<script setup>
import { computed, onMounted, ref, reactive, watch } from 'vue'
import { useColorModes } from '@coreui/vue'
import { Login, SignUp } from './Modals'
import { usePage } from '@inertiajs/vue3'
import { isEmpty } from 'lodash'
import { router } from '@inertiajs/vue3'

/**
 * The reactive data object.
 * 
 * @property {Boolean} visible - Whether the menu is visible or not.
 * @property {Object} modals - The modals object.
 * @property {Boolean} modals.login - Whether the login modal is visible or not.
 * @property {Boolean} modals.signup - Whether the signup modal is visible or not.
 */
const $data = reactive({
  visible: false,
  modals: {
    login: false,
    signup: false
  }
});

/**
 * The computed property for the authenticated user.
 * 
 * @return {Object} - The authenticated user object.
 */
const auth_user = computed( () => usePage().props.auth.user )

const logout    = async () => router.post(route('landing.logout'));

/**
 * Watch the signup modal and toggle the login modal
 */
watch( 
 ()      => $data.modals.signup,
 (value) => {
  /**
   * If the signup modal is visible, hide the login modal
   */
  if(value) $data.modals.login = false;
 }  
);

/**
 * Watch the login modal and toggle the signup modal
 */
watch( 
 ()      => $data.modals.login,
 (value) => {
  /**
   * If the login modal is visible, hide the signup modal
   */
  if(value) $data.modals.signup = false;
 }  
)
</script>

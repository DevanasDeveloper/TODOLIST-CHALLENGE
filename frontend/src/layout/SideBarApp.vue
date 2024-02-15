<template>
    <!-- ======= Sidebar ======= -->
  <aside v-if="isLoggedIn" id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
    <!-- Start Dashboard Nav -->
    <li class="nav-item">
        <router-link class="nav-link" :class="this.$route.path=='/' ? '' : 'collapsed'" to="/">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
        </router-link>
    </li>
    <!-- End Dashboard Nav -->
    <li class="nav-item">
        <router-link class="nav-link"  :class="this.$route.path=='/todolist' ? '' : 'collapsed'" to="/todolist">
        <i class="bi bi-menu-button-wide"></i>
        <span>Todos</span>
        </router-link>
    </li><!-- End Profile Page Nav -->

    </ul>

    </aside><!-- End Sidebar-->
 </template>
 
 <script>
     export default {
         name: 'SideBarApp',
         props:{
            isLoggedIn:Boolean
        }
     }
 </script>
 
 <style>
 
 </style>
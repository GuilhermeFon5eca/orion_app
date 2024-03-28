
<template>
  <div>
    <!-- Navbar -->
    <div v-if="!dashboard_data.no_navbar">
      <navbar />
    </div>
    <!-- End Navbar -->
    <main class="main-content position-relative border-radius-lg row">
      <!-- Sidebar -->
      <sidebar v-if="!dashboard_data.no_sidebar"/>
      <!-- End Sidebar -->
      <div id="main_container" class="container-fluid py-4 col-9">
        <slot></slot>
      </div>
    </main>
    <!-- Rightbar -->
    <rightbar v-if="!dashboard_data.no_rightbar" />
    <!-- End Rightbar -->
  </div>
</template>

<script>
    import Navbar from './Navbar.vue'
    import Sidebar from './Sidebar.vue' 
    import Rightbar from './Rightbar.vue' 

    export default {
        components:{
            Navbar,
            Sidebar,
            Rightbar,
        },
        mounted() {
          console.log('Component mounted.')
        },
        props: ['dashboard_data']
    }
</script>
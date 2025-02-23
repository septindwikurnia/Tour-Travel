<template>


<div class="hero">
        <div class="hero-content">
            <h1>Explore the sights</h1>
            <h1>of the Azores</h1>
            <p>A place where nature and adventure unite</p>
            <a href="#" class="btn">Book now</a>
        </div>

        <!-- Navigasi Panah -->
        <div class="hero-navigation">
            <button class="nav-btn left-arrow">&larr;</button>
            <button class="nav-btn right-arrow">&rarr;</button>
        </div>
    </div>
</template>


<script>

import Navbar from '../components/Navbar.vue';

export default{
    name:'Main',
    components:{
        Navbar,
    }
}

</script>
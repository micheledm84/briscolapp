<template>
    <div>
        <nav class="navbar-dark bg-dark nav-fill w-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-5 mt-3">
                        <p>Missing cards: {{ remaining_cards }}</p>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-2 mt-3">
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-5 mt-3">
                        <p>{{ nav_comment }}</p>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
    
    export default {
        props: ['remaining_cards', 'nav_comment'],
        data() {
            return {
                //title: "Vue ninjas"
            }
        }
    }
</script>

<style scoped>
    p {
        color: lightgreen;
        text-align: center;
    }
    nav {
        height: 11vh;
        

    }
    @media screen and (max-height:500px) {
        nav { 
            display:none 
        }
    }
</style>
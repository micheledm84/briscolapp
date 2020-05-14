<template>
    <div>
        <footer class="bg-dark fixed-bottom">
            <div class="container">
                <div class="row mt-3">
                    <div class="col-sm-6 text-left">
                        <p>Guest is playing</p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <p>{{ copyright }}</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                copyright: "Powered by Michele Della Mea"
            }
        }
    }
</script>

<style scoped>
    footer {
        height: 11vh;
    }
    p {
        color: lightgreen;
    }
    @media screen and (max-height:500px) {
        footer { 
            display:none 
        }
    }

</style>
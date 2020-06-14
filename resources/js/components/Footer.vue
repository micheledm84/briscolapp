<template>
    <div>
        <footer class="bg-dark fixed-bottom">
            <div class="container">
                <div class="row mt-3">
                    <div class="col-sm-6 text-left">
                        <p>{{ footer_score }}</p>
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
        props: ['footer_score'],
        data() {
            return {
                copyright: "Powered by Michele's labs",
                //state: state,
            }
        },
        computed: {
            // a computed getter
            score_footer: function () {
            // `this` points to the vm instance
                //return this.message.split('').reverse().join('')
                return this.state;
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
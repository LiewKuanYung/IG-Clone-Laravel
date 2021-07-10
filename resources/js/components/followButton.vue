<template>
    <div class="container">
        <button class="btn btn-primary ml-3 mb-2" @click="followUser"  v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows'],

        mounted() {
            console.log('Component mounted.')
        },

        data: function () {
            return {
                //initial status
                status: this.follows,
            }
        },

        methods: {
            followUser(){
                axios.post('/follow/' + this.userId)
                    .then(response => {
                        //toggle the response status
                        this.status = ! this.status;
                        console.log(response.data);
                    })
                    .catch(errors => {
                        if (errors.response.status == 401) { //not logged in error
                            window.location = '/login/'
                        }
                    });
            }
        },

        computed: {
            //change button based on v-text
            buttonText() {
                return (this.status) ? 'Unfollow' : 'Follow'
            }
        },
    }
</script>

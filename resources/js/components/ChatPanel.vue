<template>
    <div class=" h-100">
        <div class="border-bottom">
            <h3 class="text-center">{{ room.name }}</h3>
        </div>
        <div class="chat overflow-auto position-relative h-75">
            <div v-for="message in messages" v-bind:class="(message.mine) ? 'mine messages' : ' yours messages'">
                <small class="px-2 text-muted">{{ message.user }}</small>
                <div class="message">
                    {{ message.text }}
                </div>
                 <small class="px-2" style="font-size:10px">{{ message.created_at }}</small>
            </div>

        </div>
        <div class=" mt-1 input-group">
            <textarea class="form-control shadow-none bg-white"
                      style="resize:none" rows="4"
                      aria-label="With textarea"
                      v-model="fields.text"
                      @keyup.enter="sendMessage()"></textarea>
            <button class="btn btn-primary"
                    type="button"
                    @click="sendMessage()">Send
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        room: Object
    },

    data() {
        return {
            info: [],
            messages: [],
            fields: {},
        };
    },
    mounted() {
        axios.get(`/api/rooms/${this.room.id}/messages`).then(response => {
            this.messages = response.data.data;
        });
    },
    created() {
        this.subscribe()
    },
    methods: {
        subscribe(){
            let pusher = new Pusher('0088f26dd9d16f7ccf5f', {
                cluster: 'eu'
            });
            let channel = pusher.subscribe('my-channel');
            channel.bind('my-event', (data) => {
                if(data.room === this.room.id )
                    this.messages.push(data);
            });
        },
        sendMessage() {
            axios.post(`/api/rooms/${this.room.id}/messages`, this.fields).then(response => {
                this.fields = {}
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
                console.log('Error');
            });


        },

    }
};
</script>

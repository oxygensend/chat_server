<template>
    <div class=" h-100">
        <div class="border-bottom">
            <h3 class="text-center">{{ room.name }}</h3>
        </div>
        <div ref="messages" class="chat overflow-auto position-relative h-75">
            <div v-for="message in messages"
                 v-bind:class="(user == message.user.id) ? 'mine messages' : ' yours messages'">
                <small class="px-2 text-muted">{{ message.user.name }}</small>
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
import {channel} from '../app'
export default {
    props: {
        room: Object,
        user: String,
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
        this.listen();
    },
    watch: {
        messages: function () {
            this.$nextTick(() => this.scrollToEnd());
        }
    },
    methods: {
        listen() {
            channel.bind('message-reciver', (data) => {
                if (data.room === this.room.id)
                    this.messages.push(data);
            });
        },
        sendMessage() {
            axios.post(`/api/rooms/${this.room.id}/messages`, this.fields).then(response => {
                this.fields = {};
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
                console.log('Error');
            });
        },

        scrollToEnd() {
            this.$refs['messages'].scrollTop = this.$refs['messages'].scrollHeight;
        }

    }
};
</script>

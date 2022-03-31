<template>
    <div class="h-100">
        <div class="border-bottom">
            <h3 class="text-center">{{ room.name }}</h3>
        </div>
        <div ref="messages" class="chat overflow-auto h-75">
            <div v-observe-visibility="handleScrolledTop"></div>
            <div v-for="message in messages"
                 v-bind:class="(user == message.user.id) ? 'mine messages' : ' yours messages'">
                <small class="px-2 text-muted">{{ message.user.name }}</small>
                <div class="message">
                    {{ message.text }}
                </div>
                <small class="px-2" style="font-size:10px">{{ message.created_at }}</small>
            </div>

        </div>
        <div class="position-absolute bottom-0 end-0   mt-1 input-group">
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
import {channel} from '../app';

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
            page: 1,
            lastPage: 1
        };
    },
    mounted() {
        this.fetch();
    },
    created() {
        this.listen();
    },
    watch: {
        messages: function () {
            const scrollTopMax = this.$refs.messages.scrollHeight - this.$refs.messages.offsetHeight;
            if (this.$refs.messages.scrollTop === scrollTopMax)
                this.$nextTick(() => this.scrollToEnd());

        }
    },
    methods: {
        async fetch() {
            const response = await axios.get(`/api/rooms/${this.room.id}/messages?page=${this.page}`);
            this.messages.unshift(...response.data.data.reverse());
            this.lastPage = response.data.meta.last_page;

        },
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
        },

        handleScrolledTop(isVisible) {
            if (!isVisible) return;
            if (this.page >= this.lastPage) return;

            this.page++;
            let firstEl = this.$refs['messages'].children.item(1);

            setTimeout(async () => {
                await this.fetch();
                this.$refs['messages'].scrollTop = firstEl.offsetTop * 10;
            }, 300);

        }

    }
};
</script>

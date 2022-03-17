<template>
    <div>
        <div class="border-bottom">
            <h3 class="text-center">Users</h3>
        </div>


        <ul class="list-group mt-4 ">
            <li class="d-flex justify-content-between align-items-center overflow-hidden mb-1"
                v-for="user in users">
                {{ user.name }}
                <span  v-bind:class="(user.online == true) ? 'bg-success' : 'bg-danger' "  class="p-2  translate-middle-x rounded-circle"></span>
            </li>

        </ul>

<!--        do poprawy na form-->
        <a class="link-primary position-absolute bottom-0" @click="disconnect" href="#">Leave room</a>
    </div>
</template>

<script>
import {channel} from "../app";

export default {
    props: {
        url: String,
        room: Object
    },
    data() {
        return {
            users: {},
        };
    },
    created() {
        this.listen();
    },
    mounted() {
        axios.get(`/api/rooms/${this.room.id}/users`).then(response => {
            this.users = response.data.data;
        });
    },
    methods: {
        listen() {
            channel.bind('active-users', (data) => {
                if (data.user.online == true) {
                   this.setUserOnline(true, data);
                }
                else {
                   this.setUserOnline(false, data);
                }
                if (!this.users.some(el=> el.id === data.user.id)) this.users.push(data.user);

            });
        },
        disconnect(){
            axios.patch(`/api/rooms/${this.room.id}/disconnect`).then(response => {
               window.location = response.data.redirect;
            });
        },

        setUserOnline(online, data){
            this.users.forEach((u, i) => {
                console.log('ll');
                if (u.id === data.user.id && u.online == !online) {
                    this.users[i].online = online;
                }
            });
        }
    }
};


</script>


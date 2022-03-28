<template>
    <div>
        <div class="border-bottom">
            <h3 class="text-center">Users</h3>
        </div>


        <ul class="list-group mt-4 ">
            <li class="d-flex justify-content-between align-items-center overflow-hidden mb-1"
                v-for="user in sortedUsers">
                {{ user.name }}
                <span v-bind:class="(user.online == true) ? 'bg-success' : 'bg-danger' "
                      class="p-2  translate-middle-x rounded-circle"></span>
            </li>

        </ul>

        <!--        do poprawy na form-->
        <button class="btn btn-danger position-absolute bottom-0 mb-4 w-75" @click="disconnect" href="">Leave room
        </button>
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
            users: [],
        };
    },
    created() {
        this.listen();

    },
    async mounted() {
        const res = await axios.get(`/api/rooms/${this.room.id}/users`);
        this.users = res.data.data;

    },
    computed: {
        sortedUsers: function () {
            function compare(a, b) {
                if (a.online < b.online)
                    return 1;
                else
                    return 0;
            }

            return this.users.sort(compare);
        }
    },
    methods: {
        listen() {
            channel.bind('active-users', (data) => {
                if (data.user.room != this.room.id)
                    return;

                if (data.user.online == true) {
                    this.setUserOnline(true, data);
                } else {
                    this.setUserOnline(false, data);
                }
                if (!this.users.some(el => el.id === data.user.id)) this.users.push(data.user);

            });
        },
        disconnect() {
            if (window.confirm('Really wanna leave?')) {
                axios.delete(`/api/rooms/${this.room.id}`).then(response => {
                    window.location = response.data.redirect;
                });
            }
        },

        setUserOnline(online, data) {
            this.users.forEach((u, i) => {
                if (u.id === data.user.id && u.online == !online) {
                    this.users[i].online = online;
                }
            });
        },

        async getUsers() {
            const res = await axios.get(`/api/rooms/${this.room.id}/users`);
            console.log(res.data.data);
            return res.data.data;

        }


    }

};


</script>

